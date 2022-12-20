<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Airtable;

class TikController extends Controller
{
    // !!! not tested yet
    public function getAuthCode(){
        $client = new \GuzzleHttp\Client();

        // $advertiser_auth_url can get from the approved app setting. Must be entered from GUI.
        $advertiser_auth_url = "https://ads.tiktok.com/marketing_api/auth?app_id=7176805706610245634&state=your_custom_params&redirect_uri=https%3A%2F%2Fwww.zrichmedia.com%2F&rid=lohuzq8pj9a";
        
        // for now, all keys are hard coded, these must be stored in DB and also if a new app is required it should be
        // got from GUI
        $app_id = "7176805706610245634";
        $app_secret = "26635d237c70e92298e7941d9799aa2559071309";
        
        // This should generate consent screen for accepting allowed roles for this app
        $response = $client->request('GET', $advertiser_auth_url, [
            'headers' => [
                'accept' => 'application/json',
            ]
        ]);

        // ====================================================
        // Get redirected url and extract auth_code from the url
        // 
        // 
        // 
        // ====================================================
        $auth_code = "ca78bda3aedbfb87c4d3b072234a668d8abba99e";
        
        // POST https://business-api.tiktok.com/open_api/v1.2/oauth2/access_token/
        // get Total revenue including outside of klaviyo
        $response = $client->request('POST', 'https://business-api.tiktok.com/open_api/v1.2/oauth2/access_token/', [
            'headers' => [
                'accept' => 'application/json',
            ],
            'body' => [
                "app_id" => $app_id,
                "auth_code" => $auth_code,
                "secret" => $app_secret
            ]
        ]);
        
        // =====================================================
        // Get Access token from the response
        // And also can get complete list of advertiser_ids
        // 
        // 
        // 
        // 
        // =====================================================
        /*
            {
                "code": 0,
                "message": "OK",
                "request_id": "20221214084814E9761A518731F801C8F8",
                "data": {
                    "access_token": "814d7c9032f9de90b5cc7c4f7b6d4e264ed16d6a",
                    "advertiser_ids": [
                        "7057883608681349122",
                        "7152801527290216450",
                        "7160605155468001281",
                        "7161177297414930434",
                        "7161828386527100930",
                        "7162982427600666626",
                        "7165272402216173570",
                        "7170008149435383809",
                        "7170083155368525826",
                        "7170743223772626945",
                        "7175229125332942850"
                    ],
                    "scope": [
                        4
                    ]
                }
            }
        */
        $access_token = "814d7c9032f9de90b5cc7c4f7b6d4e264ed16d6a";
        $advertiser_ids = ["asdfasdf", "adsfadsfa", "..."];

    }



    public function getMTDCost(){

        $client = new \GuzzleHttp\Client();

        // for now, all keys are hard coded, these must be stored in DB and also if a new app is required it should be
        // got from GUI
        $app_id = "7176805706610245634";
        $app_secret = "26635d237c70e92298e7941d9799aa2559071309";
        $access_token = "7098ae8b9e43050d0cccf3596f179da2551483af";

        // --------------------------------------------------------------------------------------------
        // Fisrt of all get the complete list of advertiser account names from $advertiser_ids array

        // get authorized ad accounts

        // GET https://business-api.tiktok.com/open_api/v1.2/oauth2/advertiser/get/?access_token=$access_token&app_id=$app_id&secret=$app_secret
        $response = $client->request('GET', "https://business-api.tiktok.com/open_api/v1.2/oauth2/advertiser/get/?access_token=".$access_token."&app_id=".$app_id."&secret=".$app_secret, [
            'headers' => [
                'accept' => 'application/json',
            ],
        ]);
        /*
            {
                "code": 0,
                "message": "OK",
                "request_id": "20221214085617F2D3C19434B4ED020221",
                "data": {
                    "list": [
                        {
                            "advertiser_id": 7057883608681349122,
                            "advertiser_name": "Trendsup LTD.0127"
                        },
                        {
                            "advertiser_id": 7152801527290216450,
                            "advertiser_name": "Miato1010"
                        }
                    ]
                }
            }
        */
        $temp_resp = $response->getBody()->getContents();
        $temp_resp = json_decode($temp_resp);

        $advertiser_ids_names = $temp_resp->data->list;
        
        $advertiser_name_id_array = array();

        foreach ($advertiser_ids_names as $adin){
            $advertiser_name_id_array[$adin->advertiser_name] = $adin->advertiser_id;
        }

        $year = date("Y");
        $month = date("m");
        $day = date("d");
        // --------------------------------------------------------------------------------------------
        // Then Run a synchronous report for individaul accounts and sumup by account
        // https://business-api.tiktok.com/open_api/v1.2/reports/integrated/get/?advertiser_id=".$ad_id."&report_type=BASIC&data_level=AUCTION_CAMPAIGN&dimensions=["campaign_id", "stat_time_day"]&start_date=".$year."-".$month."-01&end_date=".$year."-".$month."-".$day."&service_type=AUCTION&page_size=1000
        $total_cost_array = array();

        /*
            $total_cost_array = [
                [
                    "AccountName" => $ader_name,
                    "AccountID" => $ader_id,
                    "Currency" => $currency,
                    "MTD_Cost" => $mdt_cost,
                    "YTD_Cost" => $ytd_cost,
                    "January" => $january,
                    "February" => $february,
                    "March" => $march,
                    "April" => $april,
                    "May" => $may,
                    "June" => $june,
                    "July" => $july,
                    "August" => $august,
                    "September" => $september,
                    "October" => $october,
                    "November" => $november,
                    "December" => $december
                ],
                [
                    ...
                ]
            ]
        */
        $max_day_array = ['0','31','28','31','30','31','30','31','31','30','31','30','31'];
        $month_char_array = ['dummy','01','02','03','04','05','06','07','08','09','10','11','12'];
        $month_name_array = ['dummy','January','February','March','April','May','June','July','August','September','October','November','December'];

        foreach ($advertiser_name_id_array as $ader_name => $ader_id) {


            // get adgroup_id =============================================================================
            $response = $client->request('GET', "https://business-api.tiktok.com/open_api/v1.2/adgroup/get/?advertiser_id=".$ader_id."&page_size=1000", [
                'headers' => [
                    'accept' => 'application/json',
                    'Access-Token' => $access_token
                ],
            ]);
            $temp_resp = $response->getBody()->getContents();
            $temp_resp = json_decode($temp_resp);
            $adgroup_data = $temp_resp->data->list;

            $adgroup_id_arr = array();
            foreach ($adgroup_data as $agd){
                array_push($adgroup_id_arr, $agd->adgroup_id);
            }
            dd($adgroup_id_arr);
            // ============================================================================================
            $temp_ader_array = [
                'AccountName' => str_replace(' ', '', $ader_name),
                'AccountID' => (string)$ader_id,
                'Currency' => 'USD',
                'MTDCost' => 0.00,
                'MTDSales' => 0.00,
                'YTDCost' => 0.00,
                'January' => 0.00,
                'February' => 0.00,
                'March' => 0.00,
                'April' => 0.00,
                'May' => 0.00,
                'June' => 0.00,
                'July' => 0.00,
                'August' => 0.00,
                'September' => 0.00,
                'October' => 0.00,
                'November' => 0.00,
                'December' => 0.00
            ];
            $ytd_cost = 0.00;
            for ($j=1; $j <= (int)$month; $j++){
                $mdt_cost = 0.00;
                $currency = 'USD';
                if($j == (int)$month){
                    $request_string = 'https://business-api.tiktok.com/open_api/v1.2/reports/integrated/get/?advertiser_id='.$ader_id.'&report_type=BASIC&data_level=AUCTION_ADVERTISER&dimensions=["advertiser_id","stat_time_day"]&metrics=["spend","currency"]&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-'.$day.'&service_type=AUCTION&page_size=1000';
                }else {
                    $request_string = 'https://business-api.tiktok.com/open_api/v1.2/reports/integrated/get/?advertiser_id='.$ader_id.'&report_type=BASIC&data_level=AUCTION_ADVERTISER&dimensions=["advertiser_id","stat_time_day"]&metrics=["spend","currency"]&start_date='.$year.'-'.$month_char_array[$j].'-01&end_date='.$year.'-'.$month_char_array[$j].'-'.$max_day_array[$j].'&service_type=AUCTION&page_size=1000';
                }
                $response = $client->request('GET', $request_string, [
                    'headers' => [
                        'accept' => 'application/json',
                        'Access-Token' => $access_token,
                        'Content-Type' => 'application/json'
                    ],
                ]);
                /*
                    {
                        "code": 0,
                        "message": "OK",
                        "request_id": "2022121605220734B21754851AFCEF9AC9",
                        "data": {
                            "list": [
                                {
                                    "dimensions": {
                                        "advertiser_id": 7057883608681349122,
                                        "stat_time_day": "2022-12-13 00:00:00"
                                    },
                                    "metrics": {
                                        "currency": "USD",
                                        "spend": "161.45"
                                    }
                                },
                                {
                                    "dimensions": {
                                        "advertiser_id": 7057883608681349122,
                                        "stat_time_day": "2022-12-08 00:00:00"
                                    },
                                    "metrics": {
                                        "currency": "USD",
                                        "spend": "80.0"
                                    }
                                }
                            ],
                            "page_info": {
                                "total_number": 19,
                                "page_size": 19,
                                "page": 1,
                                "total_page": 1
                            }
                        }
                    }
                */
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $total_pages = $temp_resp->data->page_info->total_page;

                $data_list = $temp_resp->data->list;
                if(count($data_list) === 0){
                    $currency = "";
                }else{
                    $currency = $data_list[0]->metrics->currency;
                }
                $temp_ader_array['Currency'] = $currency;

                foreach ($data_list as $dl){
                    $mdt_cost += (float)$dl->metrics->spend;
                }

                if ((int)$total_pages != 1 || (int)$total_pages != 0){
                    for ($i=2; $i <= $total_pages; $i++){
                        $response = $client->request('GET', $request_string.'&page='.$i, [
                            'headers' => [
                                'accept' => 'application/json',
                                'Access-Token' => $access_token,
                                'Content-Type' => 'application/json'
                            ],
                        ]);

                        $temp_resp = $response->getBody()->getContents();
                        $temp_resp = json_decode($temp_resp);
                        $data_list = $temp_resp->data->list;
                        foreach ($data_list as $dl){
                            $mdt_cost += (float)$dl->metrics->spend;
                        }
                    }
                }
                if ($j == (int)$month){
                    $temp_ader_array['MTDCost'] = (float)$mdt_cost;
                    $temp_ader_array[$month_name_array[$j]] = (float)$mdt_cost;
                }else{
                    $temp_ader_array[$month_name_array[$j]] = (float)$mdt_cost;
                }
                $ytd_cost += (float)$mdt_cost;
            }
            $temp_ader_array['YTDCost'] = (float)$ytd_cost;
            array_push($total_cost_array, $temp_ader_array);
        }

        // Now feed to airtable
        $apiKey = "keyuhRHvjVg7hfPSe";
        $database = "appxRNava0JFzlq9P";
        $tableName = 'TikTok_Ads_MTD';

        $AT_client = new \Zadorin\Airtable\Client($apiKey, $database);
        
        // Remove Old Data
        $query = $AT_client->table($tableName)
            ->select('*')
            ->paginate(100);
        
        $total_old_arr = array();

        while ($recordset = $query->nextPage()) {
            $temp_arr = $recordset->fetchAll();
            array_push($total_old_arr, ...$temp_arr);
        }

        try{
            foreach ($total_old_arr as $toa){
                $AT_client->delete($toa)->execute();
            }
        }
        catch (Exception $err){
            $x = "Nothing";
        }

        foreach ($total_cost_array as $tca){
            
            $AT_client->table($tableName)
                ->insert($tca)
                ->execute();
        }
    }
}
