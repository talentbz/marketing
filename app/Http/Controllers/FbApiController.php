<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;


class FbApiController extends Controller
{
    public function getMTD( Request $request){
        $access_token = env('FB_ACCESS_TOKEN');
        $app_secret = ('FB_APP_SECRET');
        $app_id = env('FB_APP_ID');
        $id = env('FB_ACCOUNT_ID');
        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = array(
        'name',
        );
        $params = array(
        );
        echo json_encode((new AdAccount($id))->getAdCreatives(
        $fields,
        $params
        )->getResponse()->getContent(), JSON_PRETTY_PRINT);
        // $facebookAds = LaravelAds::facebookAds()->with(806688472849920);
        // $campaigns = $facebookAds->fetch()->getCampaigns();
        // dd($campaigns);
    }
}
