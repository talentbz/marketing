<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $app_secret = "814d7c9032f9de90b5cc7c4f7b6d4e264ed16d6a";
        
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
        $app_secret = "814d7c9032f9de90b5cc7c4f7b6d4e264ed16d6a";
        $access_token = "814d7c9032f9de90b5cc7c4f7b6d4e264ed16d6a";

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
        $total_revenue = $temp_resp->data->list;


        // --------------------------------------------------------------------------------------------
        // Then Run a synchronous report for individaul accounts and sumup by account
    }
}
