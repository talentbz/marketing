<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use FacebookAds\Object\AdAccount;
// use FacebookAds\Object\Fields\AdAccountFields;
// use FacebookAds\Object\Fields\AdsInsightsFields;
// use FacebookAds\Object\Campaign;
// use FacebookAds\Api;
// use FacebookAds\Logger\CurlLogger;
// use FacebookAds\Object\Values\InsightsResultDatePresetValues;

class FbApiController extends Controller
{
    public function getMTD( Request $request){
        // $access_token = env('FB_ACCESS_TOKEN');
        // $app_secret = ('FB_APP_SECRET');
        // $app_id = env('FB_APP_ID');
        // // $id = env('FB_ACCOUNT_ID');
        // $id = 'act_563903348250218';
        // $api = Api::init($app_id, $app_secret, $access_token);
        // $api->setLogger(new CurlLogger());
        // // $fields = array(
        // //     'name',
        // //     'objective',
        // //   );
        // //   $params = array(
        // //     'effective_status' => array('ACTIVE','PAUSED'),
        // //   );
        // //   echo json_encode((new AdAccount($id))->getCampaigns(
        // //     $fields,
        // //     $params
        // //   )->getResponse()->getContent(), JSON_PRETTY_PRINT);
        // $fields = array(
        //     AdAccountFields::ID,
        //     AdAccountFields::NAME,
        // );
        // $account = new AdAccount($id);
        
        // $params = array(
        //     'date_preset' => InsightsResultDatePresetValues::THIS_MONTH,
        // );
        // $account->getInsights($fields, $params);
        // dd($account);
        $id_array = [
            '833160470451699',
            '806691966182904',
            '191336861484366',
            '210621707603199',
            '1303083856568035',
            '868571924163034',
            '1025509147634198',
            '824345737750860',
            '272507143318191',
            '821893311329436',
            '2826760844244593',
            '563903348250218'
        ];
        $access_token = env('FB_ACCESS_TOKEN');
        $date_preset = 'this_month';
        $total_account_arr = array();
        foreach($id_array as $row){
            $individual_acc_arr = array();
            $individual_acc_arr['Account_ID'] = $row;
            
            // get account data
            $account_url = 'https://graph.facebook.com/v15.0/act_'.$row.'?fields=name&access_token='.$access_token;
            $account_response =Http::get($account_url);
            $account_name = json_decode($account_response->getBody()->getContents()->name);
            $individual_acc_arr['Acount_Name'] = $account_name;
            
            //get mtd data
            $mtd_url = 'https://graph.facebook.com/v15.0/act_'.$row.'/insights?date_preset='.$date_preset.'&access_token='.$access_token;
            $mtd_response =Http::get($mtd_url);
            $mtd_data = json_decode($mtd_response->getBody()->getContents()->data[0]->spend);
            $individual_acc_arr['MTD'] = $mtd_data;
            array_push($total_account_arr, $individual_acc_arr);
        }
        
        
        dd($total_account_arr);
        $response = Http::get('https://graph.facebook.com/v15.0/act_563903348250218/insights?access_token=EAAJvxJXuFCwBAJeSk9DzGGTkNBRTV7dABl26IcMhZAxesZCIZBOQ2v0ungPWZCp6IZARDYSdY7VrGna59gn7KiufDbZBKzLdJOvvWN3RlCoWZCQZAIpkhplLfqCcZAyIGfliPL5Cae6b6EZBa03TOhhInWS2cTm7ZCmyhgfnxPHHwFjOLtELeyeneKa');
        $data = json_decode($response->getBody()->getContents());
        dd($data);
        
    }
}
