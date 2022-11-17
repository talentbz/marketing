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
        $manageId = env("MANAGE_ID");
        $customerIdList = 'SELECT customer_client.id FROM customer_client WHERE customer_client.manager != TRUE AND customer_client.test_account != TRUE AND customer_client.hidden != TRUE';
        $customerIdResponse = $googleAdsClient->getGoogleAdsServiceClient()->search(
            $manageId,
            $customerIdList,
        );
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
        // return view('welcome');5943545658
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Key' => 'a8cc2f0502a2244f57e62b40a023e81cab4cd193e0f3fb54a3ef33c948539a09', 
        ])->get('https://api.hyros.com/v1/api/v1.0/attribution', [
            "attributionModel" => 'last_click',
            "startDate" => '2022-03-18',
            "endDate" => '2022-11-15',
            "level" => 'google_ad',
            "fields" => 'sales',
            "ids" => '16653716866,16865167899',
            "dayOfAttribution" => false
        ]);
        $data = json_decode($response->getBody()->getContents());
        dd($data);
        // return json_decode($response);
        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, "https://private-ea0372-hyros.apiary-mock.com/v1/api/v1.0/attribution?attributionModel={attributionModel}&startDate={startDate}&endDate={endDate}&level={level}&fields={fields}&ids={ids}&currency={currency}&dayOfAttribution={dayOfAttribution}&scientificDaysRange={scientificDaysRange}");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //   "Content-Type: application/json",
        //   "API-Key: b12a19f4521d44abc8d613efca7f9c23c88"
        // ));
        
        // $response = curl_exec($ch);
        // curl_close($ch);
        
        // var_dump($response);
        $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.hyros.com/v1/api/v1.0/tags");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "API-Key: b12a19f4521d44abc8d613efca7f9c23c88"
));

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);
    }
}
