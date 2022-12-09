<?php

namespace App\Http\Controllers;

// require_once('/vendor/autoload.php');

use Illuminate\Http\Request;
use KlaviyoAPI\KlaviyoAPI;

class KlApiController extends Controller
{
    //get MTD revenue
    public function getMTD(){

        $private_keys = ['pk_e1005be4a6673c43820a4a1c84ca081b2c'];


        $klaviyo = new KlaviyoAPI(
            'pk_e1005be4a6673c43820a4a1c84ca081b2c', 
            $num_retries = 3, 
            $wait_seconds = 3);
        
        $response = $klaviyo->Metrics->getMetrics();
        
        $placed_order_metric_id = "";
        foreach($response['data'] as $resp_data){
            if ($resp_data['attributes']['name'] == "Placed Order" && $resp_data['attributes']['integration']['name'] == "Shopify"){
                $placed_order_metric_id = $resp_data['id'];
            }
        }

        // get Total revenue including outside of klaviyo
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=value&start_date=2022-12-01&end_date=2022-12-31&api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
            'headers' => [
              'accept' => 'application/json',
            ],
          ]);
        $temp_resp = $response->getBody()->getContents();
        $temp_resp = json_decode($temp_resp);
        $total_revenue = $temp_resp->results[0]->data[0]->values[0];
        
        // get Total order count including outside of klaviyo
        $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=count&start_date=2022-12-01&end_date=2022-12-31&api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
            'headers' => [
              'accept' => 'application/json',
            ],
          ]);
        $temp_resp = $response->getBody()->getContents();
        $temp_resp = json_decode($temp_resp);
        $total_orders = $temp_resp->results[0]->data[0]->values[0];

        // ===================================================================
        // Klaviyo campaign part start
        // get klaviyo campaign id list
        $campaign_ids = array();
        $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/campaigns?api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
            'headers' => [
              'accept' => 'application/json',
            ],
          ]);
        $temp_resp = $response->getBody()->getContents();
        $temp_resp = json_decode($temp_resp);
        foreach ($temp_resp->data as $temp_data){
            array_push($campaign_ids, $temp_data->id);
        }
        // get klaviyo campaign revenue
        $campaign_revenue = 0;
        foreach ($campaign_ids as $camp_id){
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=value&where=%5B%5B%22%24attributed_message%22%2C%22%3D%22%2C%22'.$camp_id.'%22%5D%5D&start_date=2022-12-01&end_date=2022-12-31&api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
                'headers' => [
                  'accept' => 'application/json',
                ],
              ]);
            $temp_resp = $response->getBody()->getContents();
            $temp_resp = json_decode($temp_resp);
            $temp_campaign_revenue = $temp_resp->results[0]->data[0]->values[0];
            $campaign_revenue += (float)$temp_campaign_revenue;
        }

        // get klaviyo campaign orders
        $campaign_orders = 0;
        foreach ($campaign_ids as $camp_id){
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=count&where=%5B%5B%22%24attributed_message%22%2C%22%3D%22%2C%22'.$camp_id.'%22%5D%5D&start_date=2022-12-01&end_date=2022-12-31&api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
                'headers' => [
                  'accept' => 'application/json',
                ],
              ]);
            $temp_resp = $response->getBody()->getContents();
            $temp_resp = json_decode($temp_resp);
            $temp_campaign_orders = $temp_resp->results[0]->data[0]->values[0];
            $campaign_orders += (float)$temp_campaign_orders;
        }

        // ===================================================================
        // Klaviyo flow part start
        // get klaviyo flow id list
        $flow_ids = array();
        $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/flows?api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
            'headers' => [
              'accept' => 'application/json',
            ],
          ]);
        $temp_resp = $response->getBody()->getContents();
        $temp_resp = json_decode($temp_resp);
        foreach ($temp_resp->data as $temp_data){
            array_push($flow_ids, $temp_data->id);
        }
        // get klaviyo flow revenue
        $flow_revenue = 0;
        foreach ($flow_ids as $flow_id){
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=value&where=%5B%5B%22%24attributed_flow%22%2C%22%3D%22%2C%22'.$flow_id.'%22%5D%5D&start_date=2022-12-01&end_date=2022-12-31&api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
                'headers' => [
                  'accept' => 'application/json',
                ],
              ]);
            $temp_resp = $response->getBody()->getContents();
            $temp_resp = json_decode($temp_resp);
            $temp_flow_revenue = $temp_resp->results[0]->data[0]->values[0];
            $flow_revenue += (float)$temp_flow_revenue;
        }

        // get klaviyo flow orders
        $flow_orders = 0;
        foreach ($flow_ids as $flow_id){
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=count&where=%5B%5B%22%24attributed_flow%22%2C%22%3D%22%2C%22'.$flow_id.'%22%5D%5D&start_date=2022-12-01&end_date=2022-12-31&api_key=pk_e1005be4a6673c43820a4a1c84ca081b2c', [
                'headers' => [
                  'accept' => 'application/json',
                ],
              ]);
            $temp_resp = $response->getBody()->getContents();
            $temp_resp = json_decode($temp_resp);
            $temp_flow_orders = $temp_resp->results[0]->data[0]->values[0];
            $flow_orders += (float)$temp_flow_orders;
        }

        dd($flow_orders);
        // echo "<pre>";
        // echo $campaign_revenue;
        // // var_dump($temp_campaign_revenue);
        // echo "</pre>";
          
    }
}
