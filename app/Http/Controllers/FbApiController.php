<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;
use FacebookAds\Object\Fields\InsightsFields;
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
        // $fields = array(
        //     AdAccountFields::ID,
        //     AdAccountFields::NAME,
        //   );
          
          $account = new AdAccount($id);
          $fields = array(
            InsightsFields::AD_NAME,
            InsightsFields::ADSET_NAME,
            InsightsFields::CAMPAIGN_NAME,
            InsightsFields::ACCOUNT_NAME,
            InsightsFields::ACCOUNT_ID,
            InsightsFields::IMPRESSIONS,
            InsightsFields::INLINE_LINK_CLICKS,
            InsightsFields::SPEND,
            InsightsFields::AD_ID
        );
        
        $params = array(
            'date_preset' => InsightsPresets::YESTERDAY
        );
        
        $account->getInsights($fields, $params);
          dd($account);
        // $facebookAds = LaravelAds::facebookAds()->with(806688472849920);
        // $campaigns = $facebookAds->fetch()->getCampaigns();
        // dd($campaigns);
    }
}
