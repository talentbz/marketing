<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Fields\AdsInsightsFields;
use FacebookAds\Object\Campaign;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\Values\InsightsResultDatePresetValues;
use Illuminate\Support\Facades\Http;

class FbApiController extends Controller
{
    public function getMTD( Request $request){
        $access_token = env('FB_ACCESS_TOKEN');
        $app_secret = ('FB_APP_SECRET');
        $app_id = env('FB_APP_ID');
        // $id = env('FB_ACCOUNT_ID');
        $id = 'act_563903348250218';
        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());
        // $fields = array(
        //     'name',
        //     'objective',
        //   );
        //   $params = array(
        //     'effective_status' => array('ACTIVE','PAUSED'),
        //   );
        //   echo json_encode((new AdAccount($id))->getCampaigns(
        //     $fields,
        //     $params
        //   )->getResponse()->getContent(), JSON_PRETTY_PRINT);
        $fields = array(
            AdAccountFields::ID,
            AdAccountFields::NAME,
        );
        $account = new AdAccount($id);
        
        $params = array(
            'date_preset' => InsightsResultDatePresetValues::THIS_MONTH,
        );
        $account->getInsights($fields, $params);
        dd($account);
        // $response = Http::get('https://graph.facebook.com/v15.0/act_563903348250218/insights?access_token=EAAJvxJXuFCwBAGqG7OhJtWhdUhhr6TqjtI0ClV4aYJitWZAKoZANfVOzS0MepbxZC7qiJT0jV26d2qg0JNzdRTLmLXHQ8f6MWs4zHzXqqBVzIP5vTTVlZCxnGLFZB4W0YLJKxjPLInyh7uiMsIWRuKZAAShH8FWwPLJs7wf3tDPwoHJ7OL5SCAGGY90FeRDwUjNtZB7ZCwbIkoYDZBauj6APPKS36eGC7uZAEqE0yJG0NzvFvQUZBCovHU10rZBqMyayYUwZD');
        // $data = json_decode($response->getBody()->getContents());
        // dd($data);
        
    }
}
