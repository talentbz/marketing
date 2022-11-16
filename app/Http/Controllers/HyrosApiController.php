<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;
use Airtable;
use Google\Ads\GoogleAds\Lib\V12\GoogleAdsClient;

class HyrosApiController extends Controller
{
    public function getMTD( Request $request, GoogleAdsClient $googleAdsClient){
        // $manageId = env("MANAGE_ID");
        // $customerIdList = 'SELECT customer_client.id FROM customer_client WHERE customer_client.manager != TRUE AND customer_client.test_account != TRUE AND customer_client.hidden != TRUE';
        // $customerIdResponse = $googleAdsClient->getGoogleAdsServiceClient()->search(
        //     $manageId,
        //     $customerIdList,
        // );
        // foreach ($customerIdResponse->iterateAllElements() as $row){
        //     $customerId = $row->getCustomerClient()->getId();
        //     $query = 'SELECT campaign.id, customer.descriptive_name FROM campaign ORDER BY customer.id ASC';
            
        //     try {
        //         $response = $googleAdsClient->getGoogleAdsServiceClient()->search(
        //             $customerId,
        //             $query,
        //         );
        //     }
        //     catch (Exception $ex) {
        //       continue;
        //     }
        //     foreach ($response->iterateAllElements() as $sth){
        //         echo $sth->getCustomer()->getDescriptiveName().'-------->'.$sth->getCampaign()->getId();
        //         echo '<br>';
        //     }
        // }
        // dd(1);
        // return view('welcome');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Key' => 'b12a19f4521d44abc8d613efca7f9c23c88', 
        ])->get('https://private-ea0372-hyros.apiary-mock.com/v1/api/v1.0/attribution', [
            "attributionModel" => 'last_click',
            "startDate" => '2021-11-01',
            "endDate" => '2021-11-15',
            "level" => 'level',
            "fields" => 'fields',
            "ids" => '1057231095,10113550076,10127550431',
            "dayOfAttribution" => false,
            "scientificDaysRange" => 30
        ]);
        $data = json_decode($response->getBody()->getContents());
        dd($data->result);
        return json_decode($response);
    }
}
