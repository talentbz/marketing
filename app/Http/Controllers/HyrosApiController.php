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
        // return view('welcome');5943545658
        $api_key_array = [
            ['name' => 'FlashBooth', 'email'=>'support@getflashbooth.com', 'account_id'=>'3037085077', 'api_key'=>'3cc42b25696ddf6ce84626f2847163110743188b3cbb4c1dab84783cf75353f3'],
            ['name' => 'FlyFixed', 'email'=>'support@flyfixed.com', 'account_id'=>'6802743891', 'api_key'=>'1decb2a00b8d72346ad12514d0dc2effddea7d004c283c69b98bd0ff35c3650c'],
            ['name' => 'PAPERANGPRINT', 'email'=>'paperanginfo@gmail.com', 'account_id'=>'6453540254', 'api_key'=>'a03eb13cfbe8613e60465433b932f9bad91e329a37ca6924ecb8e00285c1509b'],
            ['name' => 'Boom Speaker', 'email'=>'boomspeakershop@gmail.com', 'account_id'=>'3288774100', 'api_key'=>'0f1b21056022bce9fba3a54d9c4c7c2a6ea753e703a6247acba37f45068301a5'],
            ['name' => 'CurlyShiny', 'email'=>'hello@curlyshiny.com', 'account_id'=>'7511085705', 'api_key'=>'68a862a6514d4abcb75799d2d127abbb4953333f5b961b35556db220aa103149'],
            ['name' => 'Delta Hikers', 'email'=>'deltahikers@gmail.com', 'account_id'=>'1293316717', 'api_key'=>'7ab732e3e3652e4c8fa7569413b81cfc39600dbb04fb769002c4f66cbe3b8eeb'],
            ['name' => 'Duvai', 'email'=>'support@duvai.co', 'account_id'=>'7606839896', 'api_key'=>'2e87c1113177b58ec6da4c6364c96cabf021d2debb4731c8661cf4df1547510b'],
            ['name' => 'FireDiffuser', 'email'=>'firediffuser@gmail.com', 'api_key'=>'dc6b88cf960c054594ad066143d8a9b79337e8cb2d922142202e9e774b559e92'],
            ['name' => 'FitPro', 'email'=>'care@fitprosmartwatch.com', 'account_id'=>'9621492025', 'api_key'=>'86619c770a1c657ddf25149f52ac1eaf54f080f320957674dd20c5afde6a4a54'],
            ['name' => 'Guitar Thread', 'email'=>'hello@guitarthread.com', 'account_id'=>'5943545658', 'api_key'=>'d21dc781df586fc75690c6bb5680d9cd8ce76658b8d053300f360be5013f9a96'],
            ['name' => 'Innerbility', 'email'=>'innerbility@gmaill.com', 'account_id'=>'5744363001', 'api_key'=>'ee629d1b85bdda73c4b8cd9565ab1248041ef5b8d03479dd76d7c98b1717d3a2'],
            ['name' => 'MacBook Hub', 'email'=>'hello@macbookhub.org', 'account_id'=>'3037085077', 'api_key'=>'ea91faa89c9f0a5100d2a380d7bbd050d3962291ad2334c90fed20281a46d222'],
            ['name' => 'Malibu Brands', 'email'=>'zac@zrichmedia.com', 'account_id'=>'4132824274', 'api_key'=>'4b1b11b013ddb2cfcbdb9c28e80691071c6ad84d7f45f41c9e1189702944a218'],
            ['name' => 'Molly', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'OhYaBikini', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'Petals & Bloom', 'email'=>'petalsandbloomsbham@gmail.com', 'account_id'=>'6896178013', 'api_key'=>'b1c3667cd07c493cbaec26b536d32af6429baf30c3874b44e14235222b28ef62'],
            ['name' => 'PowderedFoods', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'Power.Store', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'Pranked', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'Rug.Store', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'Sonrei', 'email'=>'dustin@sonreiskin.com', 'account_id'=>'6652702833','api_key'=>'a8cc2f0502a2244f57e62b40a023e81cab4cd193e0f3fb54a3ef33c948539a09'],
            ['name' => 'TheKittySack', 'email'=>'thekittysack@gmail.com', 'api_key'=>''],
            ['name' => 'USProDevices', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
            ['name' => 'ZRichMedia', 'email'=>'zac@zrichmedia.com', 'api_key'=>''],
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Key' => 'd21dc781df586fc75690c6bb5680d9cd8ce76658b8d053300f360be5013f9a96', 
        ])->get('https://api.hyros.com/v1/api/v1.0/attribution', [
            "attributionModel" => 'last_click',
            "startDate" => '2022-11-01',
            "endDate" => '2022-11-15',
            "level" => 'google_ad',
            "fields" => 'sales',
            "ids" => '5943545658',
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
