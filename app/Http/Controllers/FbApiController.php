<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        require_once __DIR__ . '../../../vendor/autoload.php';
        $fb = new \Facebook\Facebook([
            'app_id' => env('FB_APP_ID'),
            'app_secret' => env('FB_APP_SECRET'),
            'default_graph_version' => 'v2.10',
            //'default_access_token' => '{access-token}', // optional
          ]);
          
          // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
          //   $helper = $fb->getRedirectLoginHelper();
          //   $helper = $fb->getJavaScriptHelper();
          //   $helper = $fb->getCanvasHelper();
          //   $helper = $fb->getPageTabHelper();
          
          try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me', env('FB_ACCESS_TOKEN'));
          } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
          
          $me = $response->getGraphUser();
          echo 'Logged in as ' . $me->getName();
    }
}
