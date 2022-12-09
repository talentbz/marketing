<?php

namespace App\Http\Controllers;

// require_once('/vendor/autoload.php');

use Illuminate\Http\Request;
use KlaviyoAPI\KlaviyoAPI;
use Airtable;
use Vluzrmos\SlackApi\Contracts\SlackChat;

class KlApiController extends Controller
{
    protected $slackChat;

    public function __construct(SlackChat $slackChat){
        $this->slackChat = $slackChat;
    }

    //get MTD revenue
    public function getMTD(){

        $channel = '#omnisendstats';

        $apiKey = "keyuhRHvjVg7hfPSe";
        $database = "appLp38C203S7B4e5";
        $tableName = 'MTD_revenue';

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


        $private_keys = [
            'FITPROSMARTWATCH.COM' => 'pk_e1005be4a6673c43820a4a1c84ca081b2c',
            'Paperang' => 'pk_59281d7ff0770b370d4edac661f75b9160',
            'Innerbility' => 'pk_a5e8dec71039c7a3e333d289fc4c9355c3',
            'FlashBooth' => 'pk_3229a36a2abb2afd20f56ea7d69a669084',
            'Delta Hikers' => 'pk_31ace54372599f78b0d21fbb727774aed9',
            'duvai' => 'pk_51fc06b3eac8b010acc04f6c03060c619b',
        ];

        $year = date("Y");
        $month = date("m");
        $day = date("d");

        $last_month = (int)$month - 1;
        if ($last_month < 10){
            $last_month = "0".(string)$last_month;
        }
        $last_month = (string)$last_month;

        foreach ($private_keys as $store_name => $api_key){

            $klaviyo = new KlaviyoAPI(
                $api_key, 
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
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=value&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-31&api_key='.$api_key, [
                'headers' => [
                'accept' => 'application/json',
                ],
            ]);
            $temp_resp = $response->getBody()->getContents();
            $temp_resp = json_decode($temp_resp);
            $total_revenue = $temp_resp->results[0]->data[0]->values[0];
            
            // get Total order count including outside of klaviyo
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=count&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-31&api_key='.$api_key, [
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
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/campaigns?api_key='.$api_key, [
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
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=value&where=%5B%5B%22%24attributed_message%22%2C%22%3D%22%2C%22'.$camp_id.'%22%5D%5D&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-31&api_key='.$api_key, [
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
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=count&where=%5B%5B%22%24attributed_message%22%2C%22%3D%22%2C%22'.$camp_id.'%22%5D%5D&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-31&api_key='.$api_key, [
                    'headers' => [
                    'accept' => 'application/json',
                    ],
                ]);
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $temp_campaign_orders = $temp_resp->results[0]->data[0]->values[0];
                $campaign_orders += (float)$temp_campaign_orders;
            }

            // -----------------------------------
            // Klaviyo campaign part start (Last month)
            // get klaviyo campaign revenue
            $last_month_campaign_revenue = 0;
            foreach ($campaign_ids as $camp_id){
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=day&measurement=value&where=%5B%5B%22%24attributed_message%22%2C%22%3D%22%2C%22'.$camp_id.'%22%5D%5D&start_date='.$year.'-'.$last_month.'-01&end_date='.$year.'-'.$last_month.'-'.$day.'&api_key='.$api_key, [
                    'headers' => [
                    'accept' => 'application/json',
                    ],
                ]);
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $temp_campaign_revenue = 0;
                foreach ($temp_resp->results[0]->data as $data){
                    $temp_campaign_revenue += (float)($data->values[0]);
                }
                $last_month_campaign_revenue += (float)$temp_campaign_revenue;
            }

            // get klaviyo campaign orders
            $last_month_campaign_orders = 0;
            foreach ($campaign_ids as $camp_id){
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=day&measurement=count&where=%5B%5B%22%24attributed_message%22%2C%22%3D%22%2C%22'.$camp_id.'%22%5D%5D&start_date='.$year.'-'.$last_month.'-01&end_date='.$year.'-'.$last_month.'-'.$day.'&api_key='.$api_key, [
                    'headers' => [
                    'accept' => 'application/json',
                    ],
                ]);
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $temp_campaign_orders = 0;
                foreach ($temp_resp->results[0]->data as $data){
                    $temp_campaign_orders += (float)($data->values[0]);
                }
                $last_month_campaign_orders += (float)$temp_campaign_orders;
            }

            // ===================================================================
            // Klaviyo flow part start
            // get klaviyo flow id list
            $flow_ids = array();
            $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/flows?api_key='.$api_key, [
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
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=value&where=%5B%5B%22%24attributed_flow%22%2C%22%3D%22%2C%22'.$flow_id.'%22%5D%5D&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-31&api_key='.$api_key, [
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
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=month&measurement=count&where=%5B%5B%22%24attributed_flow%22%2C%22%3D%22%2C%22'.$flow_id.'%22%5D%5D&start_date='.$year.'-'.$month.'-01&end_date='.$year.'-'.$month.'-31&api_key='.$api_key, [
                    'headers' => [
                    'accept' => 'application/json',
                    ],
                ]);
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $temp_flow_orders = $temp_resp->results[0]->data[0]->values[0];
                $flow_orders += (float)$temp_flow_orders;
            }

            // --------------------------------------------------
            // Klaviyo flow part start (last month)
            
            // get klaviyo flow revenue
            $last_month_flow_revenue = 0;
            foreach ($flow_ids as $flow_id){
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=day&measurement=value&where=%5B%5B%22%24attributed_flow%22%2C%22%3D%22%2C%22'.$flow_id.'%22%5D%5D&start_date='.$year.'-'.$last_month.'-01&end_date='.$year.'-'.$last_month.'-'.$day.'&api_key='.$api_key, [
                    'headers' => [
                    'accept' => 'application/json',
                    ],
                ]);
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $temp_flow_revenue = 0;
                foreach ($temp_resp->results[0]->data as $data){
                    $temp_flow_revenue += (float)($data->values[0]);
                }
                $last_month_flow_revenue += (float)$temp_flow_revenue;
            }

            // get klaviyo flow orders
            $last_month_flow_orders = 0;
            foreach ($flow_ids as $flow_id){
                $response = $client->request('GET', 'https://a.klaviyo.com/api/v1/metric/'.$placed_order_metric_id.'/export?unit=day&measurement=count&where=%5B%5B%22%24attributed_flow%22%2C%22%3D%22%2C%22'.$flow_id.'%22%5D%5D&start_date='.$year.'-'.$last_month.'-01&end_date='.$year.'-'.$last_month.'-'.$day.'&api_key='.$api_key, [
                    'headers' => [
                    'accept' => 'application/json',
                    ],
                ]);
                $temp_resp = $response->getBody()->getContents();
                $temp_resp = json_decode($temp_resp);
                $temp_flow_orders = 0;
                foreach ($temp_resp->results[0]->data as $data){
                    $temp_flow_orders += (float)($data->values[0]);
                }
                $last_month_flow_orders += (float)$temp_flow_orders;
            }


            $total_klaviyo_revenue = $campaign_revenue + $flow_revenue;
            $total_klaviyo_orders = $campaign_orders + $flow_orders;

            $last_same_period_klaviyo_revenue = $last_month_campaign_revenue + $last_month_flow_revenue;
            $last_same_period_klaviyo_orders = $last_month_campaign_orders + $last_month_flow_orders;

            // Percent increase (or decrease) = (Period 2 – Period 1) / Period 1 * 100.
            if((int)$last_same_period_klaviyo_revenue == 0){
                $mom_change_revenue = 0;
            }else{
                $mom_change_revenue = ($total_klaviyo_revenue - $last_same_period_klaviyo_revenue) / $last_same_period_klaviyo_revenue * 100;
            }

            if((int)$last_same_period_klaviyo_orders == 0){
                $mom_change_orders = 0;
            }else{
                $mom_change_orders = ($total_klaviyo_orders - $last_same_period_klaviyo_orders) / $last_same_period_klaviyo_orders * 100;
            }

            $row = array();

            $row['Name'] = $store_name;
            $row['RevKlaviyo'] = $total_klaviyo_revenue;
            $row['RevCampaign'] = $campaign_revenue;
            $row['RevFlow'] = $flow_revenue;
            $row['RevTotal'] = $total_revenue;
            $row['OrdKlaviyo'] = $total_klaviyo_orders;
            $row['OrdCampaign'] = $campaign_orders;
            $row['OrdFlow'] = $flow_orders;
            $row['OrdTotal'] = $total_orders;
            $row['MoMrevenue'] = $mom_change_revenue;
            $row['MoMorder'] = $mom_change_orders;

            // insert into airtable
            $AT_client->table($tableName)
                ->insert($row)
                ->execute();
            
            // =======================================================================
            // Slack channel
            $top_most_block = [
                "type" => "header",
                "text" => [
                    "type" => "plain_text",
                    "text" => ":large_blue_diamond:     :large_blue_diamond:     :large_blue_diamond:",
                    "emoji" => True
                ]
            ];
            $header_block = [
                "type" => "header",
                "text" => [
                    "type" => "plain_text",
                    "text" => "MTD revenue - from Klaviyo.com  :earth_americas:",
                    "emoji" => True
                ]
            ];

            $date_block = [
                "type" => "header",
                "text" => [
                    "type" => "plain_text",
                    "text" => $store_name."      ".$month."/".$day."/".$year,
                    "emoji" => True
                ]
            ];
    
            $divider_block = [
                "type" => "divider"
            ];

            $revenue_block = [
                "type" => "section",
                "fields" => [
                    [
                        "type" => "plain_text",
                        "text" => "From Klaviyo : $".$total_klaviyo_revenue,
                        "emoji" => True
                    ],
                    [
                        "type" => "plain_text",
                        "text" => "From Campaigns : $".$campaign_revenue,
                        "emoji" => True
                    ],
                    [
                        "type" => "plain_text",
                        "text" => "From Flow : $".$flow_revenue,
                        "emoji" => True
                    ],
                    [
                        "type" => "plain_text",
                        "text" => "Total Revenue : $".$total_revenue,
                        "emoji" => True
                    ]
                ]
            ];

            $orders_block = [
                "type" => "section",
                "fields" => [
                    [
                        "type" => "plain_text",
                        "text" => "From Klaviyo : ".$total_klaviyo_orders." orders",
                        "emoji" => True
                    ],
                    [
                        "type" => "plain_text",
                        "text" => "From Campaigns : ".$campaign_orders." orders",
                        "emoji" => True
                    ],
                    [
                        "type" => "plain_text",
                        "text" => "From Flow : ".$flow_orders." orders",
                        "emoji" => True
                    ],
                    [
                        "type" => "plain_text",
                        "text" => "Total orders : ".$total_orders." orders",
                        "emoji" => True
                    ]
                ]
            ];


            $compare_block_header = [
                "type" => "header",
                "text" => [
                    "type" => "plain_text",
                    "text" => "MoM change",
                    "emoji" => True
                ]
            ];
    
            $compare_block = [
                "type" => "section",
                "fields" => [
                    [
                        "type" => "plain_text",
                        "text" => "MoM change in revenue : ".$mom_change_revenue." %",
                        "emoji" => True
                        ],
                    [
                        "type" => "plain_text",
                        "text" => "MoM change in orders : ".$mom_change_orders." %",
                        "emoji" => True
                    ]
                ]
            ];

            $block_data = [$top_most_block, $divider_block, $date_block, $divider_block, $header_block, $divider_block, $revenue_block, $divider_block, $orders_block,
                      $divider_block, $compare_block_header, $compare_block];
            $block_data = json_encode($block_data);

            $chat_result = $this->slackChat->message($channel, "",["parse" => "full", "blocks" => $block_data]);
        }
    }
}
