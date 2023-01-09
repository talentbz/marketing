<?php

/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Http\Controllers;

use Exception;
use Error;
use Airtable;
use Illuminate\Support\Facades\Http;
use Google\Ads\GoogleAds\Lib\V12\GoogleAdsClient;
use Google\Ads\GoogleAds\Util\FieldMasks;
use Google\Ads\GoogleAds\Util\V12\ResourceNames;
use Google\Ads\GoogleAds\V12\Enums\CampaignStatusEnum\CampaignStatus;
use Google\Ads\GoogleAds\V12\Resources\Campaign;
use Google\Ads\GoogleAds\V12\Services\CampaignOperation;
use Google\Ads\GoogleAds\V12\Services\GoogleAdsRow;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use App\Models\GoogleHyros;

class GoogleAdsApiController extends Controller
{
    private static $REPORT_TYPE_TO_DEFAULT_SELECTED_FIELDS = [
        'campaign' => ['campaign.id', 'campaign.name', 'campaign.status'],
        'customer' => ['customer.id']
    ];

    private const RESULTS_LIMIT = 100;

    /**
     * Controls a POST or GET request submitted in the context of the "Show Report" form.
     *
     * @param Request $request the HTTP request
     * @param GoogleAdsClient $googleAdsClient the Google Ads API client
     * @return View the view to redirect to after processing
     */
    public function showReportAction(
        Request $request,
        GoogleAdsClient $googleAdsClient
    ): View {
        if ($request->method() === 'POST') {
            // Retrieves the form inputs.
            $customerId = $request->input('customerId');
            $reportType = $request->input('reportType');
            $reportRange = $request->input('reportRange');
            $entriesPerPage = $request->input('entriesPerPage');
            
            // Retrieves the list of metric fields to select filtering out the static ones.
            $selectedFields = array_values(
                $request->except(
                    [
                        '_token',
                        'customerId',
                        'reportType',
                        'reportRange',
                        'entriesPerPage'
                    ]
                )
            );
            
            // Merges the list of metric fields to the resource ones that are selected by default.
            $selectedFields = array_merge(
                self::$REPORT_TYPE_TO_DEFAULT_SELECTED_FIELDS[$reportType],
                $selectedFields
            );

            // Builds the GAQL query.
            $query = sprintf(
                "SELECT %s FROM %s WHERE metrics.impressions > 0 AND segments.date " .
                "DURING %s LIMIT %d",
                join(", ", $selectedFields),
                $reportType,
                $reportRange,
                self::RESULTS_LIMIT
            );
            
            // Initializes the list of page tokens. Page tokens are used to request specific pages
            // of results from the API. They are especially useful to optimize navigation between
            // pages as there is no need to cache all the results before displaying.
            // More details can be found here:
            // https://developers.google.com/google-ads/api/docs/reporting/paging.
            //
            // The first page's token is always an empty string.
            $pageTokens = [''];

            // Updates the session with all the information that is necessary to process any
            // future requests (report result pages).
            $request->session()->put('customerId', $customerId);
            $request->session()->put('selectedFields', $selectedFields);
            $request->session()->put('entriesPerPage', $entriesPerPage);
            $request->session()->put('query', $query);
            $request->session()->put('pageTokens', $pageTokens);
        } else {
            // Loads from the session all the information that is necessary to process any
            // requests (report result page).
            $customerId = $request->session()->get('customerId');
            $selectedFields = $request->session()->get('selectedFields');
            $entriesPerPage = $request->session()->get('entriesPerPage');
            $query = $request->session()->get('query');
            $pageTokens = $request->session()->get('pageTokens');
        }

        // Determines the number of the page to load (the first one by default).
        $pageNo = $request->input('page') ?: 1;
        
        // Fetches next pages in sequence and stores their page tokens until the page token of the
        // requested page is retrieved.
        while (count($pageTokens) < $pageNo) {
            // Fetches the next unknown page.
            $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
                $customerId,
                $query,
                [
                    'pageSize' => $entriesPerPage,
                    // Requests to return the total results count. This is necessary to
                    // determine how many pages of results exist.
                    'returnTotalResultsCount' => true,
                    // There is no need to go over the pages we already know the page tokens for.
                    // Fetches the last page we know the page token for so that we can retrieve the
                    // token of the page that comes after it.
                    'pageToken' => end($pageTokens)
                ]
            );
            if ($response->getPage()->getNextPageToken()) {
                // Stores the page token of the page that comes after the one we just fetched if
                // any so that it can be reused later if necessary.
                $pageTokens[] = $response->getPage()->getNextPageToken();
            } else {
                // Otherwise changes the requested page number for the latest page that we have
                // fetched until now, the requested page number was invalid.
                $pageNo = count($pageTokens);
            }
        }
        // Fetches the actual page that we want to display the results of.
        
        $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
            $customerId,
            $query,
            [
                'pageSize' => $entriesPerPage,
                // Requests to return the total results count. This is necessary to
                // determine how many pages of results exist.
                'returnTotalResultsCount' => true,
                // The page token of the requested page is in the page token list because of the
                // processing done in the previous loop.
                'pageToken' => $pageTokens[$pageNo - 1]
            ]
        );
        if ($response->getPage()->getNextPageToken()) {
            // Stores the page token of the page that comes after the one we just fetched if any so
            // that it can be reused later if necessary.
            $pageTokens[] = $response->getPage()->getNextPageToken();
        }

        // Determines the total number of results to display.
        // The total results count does not take into consideration the LIMIT clause of the query
        // so we need to find the minimal value between the limit and the total results count.
        $totalNumberOfResults = min(
            self::RESULTS_LIMIT,
            $response->getPage()->getResponseObject()->getTotalResultsCount()
        );

        // Extracts the results for the requested page.
        $results = [];
        foreach ($response->getPage()->getIterator() as $googleAdsRow) {
            /** @var GoogleAdsRow $googleAdsRow */
            // Converts each result as a Plain Old PHP Object (POPO) using JSON.
            $results[] = json_decode($googleAdsRow->serializeToJsonString(), true);
        }

        // Creates a length aware paginator to supply a given page of results for the view.
        $paginatedResults = new LengthAwarePaginator(
            $results,
            $totalNumberOfResults,
            $entriesPerPage,
            $pageNo,
            ['path' => url('show-report')]
        );

        // Updates the session with the known page tokens to avoid unnecessary requests during
        // future page navigation.
        $request->session()->put('pageTokens', $pageTokens);

        // Redirects to the view that displays fields of paginated report results.
        return view(
            'report-result',
            compact('paginatedResults', 'selectedFields')
        );
    }

    /**
     * Controls a POST request submitted in the context of the "Pause Campaign" form.
     *
     * @param Request $request the HTTP request
     * @param GoogleAdsClient $googleAdsClient the Google Ads API client
     * @return View the view to redirect to after processing
     */
    public function pauseCampaignAction(
        Request $request,
        GoogleAdsClient $googleAdsClient
    ): View {
        // Retrieves the form inputs.
        $customerId = $request->input('customerId');
        $campaignId = $request->input('campaignId');

        // Deducts the campaign resource name from the given IDs.
        $campaignResourceName = ResourceNames::forCampaign($customerId, $campaignId);

        // Creates a campaign object and sets its status to PAUSED.
        $campaign = new Campaign();
        $campaign->setResourceName($campaignResourceName);
        $campaign->setStatus(CampaignStatus::PAUSED);

        // Constructs an operation that will pause the campaign with the specified resource
        // name, using the FieldMasks utility to derive the update mask. This mask tells the
        // Google Ads API which attributes of the campaign need to change.
        $campaignOperation = new CampaignOperation();
        $campaignOperation->setUpdate($campaign);
        $campaignOperation->setUpdateMask(FieldMasks::allSetFieldsOf($campaign));

        // Issues a mutate request to pause the campaign.
        
        $googleAdsClient->getCampaignServiceClient()->mutateCampaigns(
            $customerId,
            [$campaignOperation]
        );

        // Builds the GAQL query to retrieve more information about the now paused campaign.
        $query = sprintf(
            "SELECT campaign.id, campaign.name, campaign.status FROM campaign " .
            "WHERE campaign.resource_name = '%s' LIMIT 1",
            $campaignResourceName
        );

        // Searches the result.
        $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
            $customerId,
            $query
        );

        // Fetches and converts the result as a POPO using JSON.
        $campaign = json_decode(
            $response->iterateAllElements()->current()->getCampaign()->serializeToJsonString(),
            true
        );

        return view(
            'pause-result',
            compact('customerId', 'campaign')
        );
    }
    public function getCost( Request $request, GoogleAdsClient $googleAdsClient){
        $apiKey = env("AIRTABLE_KEY");
        $database = env("AIRTABLE_BASE");
        $tableName = 'GAds-testing';
        $client = new \Zadorin\Airtable\Client($apiKey, $database);
        
        $query = $client->table($tableName)
            ->select('*')
            ->paginate(100);
        
        $total_old_arr = array();

        while ($recordset = $query->nextPage()) {
            $temp_arr = $recordset->fetchAll();
            array_push($total_old_arr, ...$temp_arr);
        }

        try{
            foreach ($total_old_arr as $toa){
                $client->delete($toa)->execute();
                usleep(250000);

            }
        }
        catch (Exception $err){
            $x = "Nothing";
        }

        $camp_status_arr = ['unknown_0', 'unkown_1', 'Eligible', 'Paused', 'Removed', 'unkown_5', 'unkown_6', 'unkown_7', 'unkown_8', 'unkown_9'];
        $customerIdList = 'SELECT customer_client.id FROM customer_client WHERE customer_client.manager != TRUE AND customer_client.test_account != TRUE AND customer_client.hidden != TRUE';
        $manageId = env("GA_MANAGE_ID");
        $customerIdResponse = $googleAdsClient->getGoogleAdsServiceClient()->search(
            $manageId,
            $customerIdList,
        );

        $data_array = array();

        foreach ($customerIdResponse->iterateAllElements() as $row){
            $customerId = $row->getCustomerClient()->getId();
            $query = 'SELECT campaign.status, campaign.name, campaign.id, metrics.cost_micros, customer.currency_code, customer.id, customer.descriptive_name FROM campaign ORDER BY customer.id ASC';
            
            try {
                $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
                    $customerId,
                    $query,
                );
            }
            catch (Exception $ex) {
              continue;
            }
            $temp_array = array();
            
            foreach ($response->iterateAllElements() as $sth){
                $cost = round($sth->getMetrics()->getCostMicros() / 1000000, 2);
                $temp_array['CustomerName'] = $sth->getCustomer()->getDescriptiveName();
                $temp_array['CustomerID'] = $sth->getCustomer()->getId();
                $temp_array['CampaignName'] = $sth->getCampaign()->getName();
                $temp_array['CampaignID'] = $sth->getCampaign()->getId();
                $temp_array['CampaignStatus'] = $camp_status_arr[$sth->getCampaign()->getStatus()];
                $temp_array['Cost'] = $cost;
                $temp_array['Currency'] = $sth->getCustomer()->getCurrencyCode();
                
                array_push($data_array, $temp_array);
            }
        }
        // dd($data_array);
        foreach ($data_array as $da){
            $client->table($tableName)
            ->insert($da)
            ->execute();
            usleep(250000);
        }
        
    }

    public function getMTD( Request $request, GoogleAdsClient $googleAdsClient){
        $manageId = env("GA_MANAGE_ID");
        $customerIdList = 'SELECT customer_client.id, customer_client.descriptive_name, customer_client.currency_code FROM customer_client WHERE customer_client.manager != TRUE AND customer_client.test_account != TRUE AND customer_client.hidden != TRUE';
        $customerIdResponse = $googleAdsClient->getGoogleAdsServiceClient()->search(
            $manageId,
            $customerIdList,
        );

        $total_account_arr = array();

        $current_month = date('m');
        $current_month_zero = '';
        for ($i = 1; $i <= $current_month; $i++){
            if ($i < 10){
                $current_month_zero = (string)("0".$i);
            }else{
                $current_month_zero = (string)$i;
            }
        }
        $current_date = date('d');
        $current_date_zero = '';        
        for ($i = 1; $i <= $current_date; $i++){
            if ($i < 10){
                $current_date_zero = (string)("0".$i);
            }else{
                $current_date_zero = (string)$i;
            }
        }
        // hyros api key list
        $api_key_array = GoogleHyros::where('status', 1)->get();
        foreach ($customerIdResponse->iterateAllElements() as $row){
            
            $individual_acc_arr = array();

            $customerId = $row->getCustomerClient()->getId();
            $customer_name = $row->getCustomerClient()->getDescriptiveName();
            $currency_code = $row->getCustomerClient()->getCurrencyCode();

            $individual_acc_arr['GAds_Account_ID'] = $customerId;
            $individual_acc_arr['Currency'] = $currency_code;
            $individual_acc_arr['Store_Name'] = $customer_name;

            $this_month = 'SELECT metrics.cost_micros FROM customer WHERE segments.date DURING THIS_MONTH';
            
            try {
                $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
                    $customerId,
                    $this_month,
                );
            }
            catch (Exception $ex) {
              continue;
            }

            $month_name_arr = ["nothing", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

            foreach ($response->iterateAllElements() as $month){
                $individual_acc_arr['MTD_Cost'] = round($month->getMetrics()->getCostMicros() / 1000000, 2);
            }
            for ($j = 1; $j <= 12; $j++){
                $individual_acc_arr[$month_name_arr[$j]] = 0;
            }
            
            for ($i = 1; $i <= $current_month; $i++){
                if ($i < 10){
                    $month_str = (string)("0".$i);
                }else{
                    $month_str = (string)$i;
                }
                
                $query_template = "SELECT metrics.cost_micros FROM customer WHERE segments.month = '2023-".$month_str."-01'";

                try {
                    $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
                        $customerId,
                        $query_template,
                    );
                }
                catch (Exception $ex) {
                  continue;
                }

                foreach ($response->iterateAllElements() as $temp_cost){
                    $individual_acc_arr[$month_name_arr[$i]] = round($temp_cost->getMetrics()->getCostMicros() / 1000000, 2);
                }
            }
          
            $ytd = 0;

            for ($j = 1; $j <= 12; $j++){
                $ytd += $individual_acc_arr[$month_name_arr[$j]];
            }

            $individual_acc_arr["YTD_Cost"] = $ytd;

            // get rev data in hyros
            foreach($api_key_array as $api_row){
                if(isset($api_row['account_id']) && $api_row['account_id']==$customerId){
                    $campaign_query = 'SELECT campaign.id, customer.descriptive_name, campaign.status FROM campaign WHERE campaign.status = "ENABLED" AND campaign.status != "UNKNOWN" AND segments.date DURING THIS_MONTH ORDER BY customer.id ASC';
                    
                    try {
                        $get_campaign = $googleAdsClient->getGoogleAdsServiceClient()->search(
                            $customerId,
                            $campaign_query,
                        );
                    }
                    catch (Exception $ex) {
                        continue;
                    }
                    $total_rev = 0;
                    foreach ($get_campaign->iterateAllElements() as $campaign_row){
                        $get_hyros_data = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            'API-Key' => $api_row['api_key'], 
                        ])->get('https://api.hyros.com/v1/api/v1.0/attribution', [
                            "attributionModel" => 'last_click',
                            "startDate" => '2023-'.$current_month_zero.'-01',
                            "endDate" => '2023-'.$current_month_zero.'-'.$current_date_zero,
                            'currency' => 'user_currency',
                            "level" => 'google_campaign',
                            "fields" => 'revenue, sales, total_revenue',
                            "ids" => $campaign_row->getCampaign()->getId(),
                            "dayOfAttribution" => false,
                        ]);
                        if($get_hyros_data->getStatusCode() == 200){
                            $data = json_decode($get_hyros_data->getBody()->getContents());
                            // dd($data->result[0]->revenue);
                            $total_rev += $data->result[0]->revenue;
                        }
                    }
                    $individual_acc_arr["MTD_Sales"] = $total_rev;
                }
            }


            array_push($total_account_arr, $individual_acc_arr);
        }
        
        // Airtable API initialization
        $apiKey = env("AIRTABLE_KEY");
        $database = env("AIRTABLE_BASE");
        $tableName = 'GAds_Account_MTD';
        $client = new \Zadorin\Airtable\Client($apiKey, $database);
        
        // Remove Old Data
        $query = $client->table($tableName)
            ->select('*')
            ->paginate(100);
        
        $total_old_arr = array();

        while ($recordset = $query->nextPage()) {
            $temp_arr = $recordset->fetchAll();
            array_push($total_old_arr, ...$temp_arr);
        }

        try{
            foreach ($total_old_arr as $toa){
                $client->delete($toa)->execute();
                usleep(250000);

            }
        }
        catch (Exception $err){
            $x = "Nothing";
        }
        
        // Insert new data to Airtable
        foreach ($total_account_arr as $taa){
            $client->table($tableName)
            ->insert($taa)
            ->execute();
            usleep(250000);
        }
    }
}


/*

    $total_account_arr = [
        [
            "Store Name" => "Boom Speaker",
            "GAds Account ID" => 231435152345,//
            "Currency" => "usd",
            "MTD Cost" => 345.45,//
            "YTD Cost" => 2314.54,
            "January" => 234.54,
            .....
            "December" => 0

        ],
        
        "fasasda" => [
            .....
        ],

    ]

*/