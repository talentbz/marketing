<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;
use Error;
use Airtable;

class FbApiController extends Controller
{
    public function getMTD( Request $request){
        $id_array = [
          // '833160470451699',
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
      $total_account_arr = array();
      $this_year = date('y');
      $current_month = date('m');
      $today = date('d');
      $month_name_arr = ["nothing", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      
      foreach($id_array as $row){
          $individual_acc_arr = array();
          $individual_acc_arr['FB_Account_ID'] = $row;
          
          // get account data
          $account_url = 'https://graph.facebook.com/v15.0/act_'.$row.'?fields=name&access_token='.$access_token;
          $account_response =Http::get($account_url);
          $account_name = json_decode($account_response->getBody()->getContents())->name;
          $individual_acc_arr['Store_Name'] = $account_name;
          
          //get mtd data
          $mtd_url = 'https://graph.facebook.com/v15.0/act_'.$row.'/insights?date_preset=this_month&access_token='.$access_token;
          $mtd_response =Http::get($mtd_url);
          $mtd_data = json_decode($mtd_response->getBody()->getContents());
          $mtd = 0;
          if($mtd_data->data && $mtd_data->data[0] && $mtd_data->data[0]->spend){
              $mtd = $mtd_data->data[0]->spend;
          }
          $individual_acc_arr['MTD_Cost'] = (float)$mtd;

          //get every month MTD
          for ($j = 1; $j <= 12; $j++){
            $individual_acc_arr[$month_name_arr[$j]] = 0;
          }
          for ($i = 1; $i <= $current_month; $i++){
            if ($i < 10){
                $month_str = (string)("0".$i);
            }else{
                $month_str = (string)$i;
            }
            $date_start = $this_year.'-'.$month_str.'-'.'01';
            $date_stop = date($this_year.'-'.$month_str.'-t', strtotime($first_day));
            $mtd_url = 'https://graph.facebook.com/v15.0/act_'.$row.'/insights?date_start='.$date_start.'&date_stop='.$date_stop.'&access_token='.$access_token;
            $mtd_response =Http::get($mtd_url);
            $mtd_data = json_decode($mtd_response->getBody()->getContents());
            $mtd = 0;
            if($mtd_data->data && $mtd_data->data[0] && $mtd_data->data[0]->spend){
                $mtd = $mtd_data->data[0]->spend;
            }
            $individual_acc_arr[$month_name_arr[$i]] = (float)$mtd;
            
         }

         //get YTD data
         $ytd_url = 'https://graph.facebook.com/v15.0/act_'.$row.'/insights?date_preset=this_year&access_token='.$access_token;
         $ytd_response =Http::get($ytd_url);
         $ytd_data = json_decode($ytd_response->getBody()->getContents());
         $ytd = 0;
         if($ytd_data->data && $ytd_data->data[0] && $ytd_data->data[0]->spend){
            $ytd = $ytd_data->data[0]->spend;
         }
         $individual_acc_arr['YTD_Cost'] = (float)$ytd;
         
          // get MTD sales from hyros
          $fb_hyros = [
              ['name' => 'OT_curlyshiny_Httpool','account_id'=>'868571924163034', 'email'=>'hello@curlyshiny.com', 'api_key'=>'68a862a6514d4abcb75799d2d127abbb4953333f5b961b35556db220aa103149'],
              ['name' => 'PAPERANGPRINT #1', 'account_id'=>'1025509147634198', 'email'=>'paperanginfo@gmail.com', 'api_key'=>'a03eb13cfbe8613e60465433b932f9bad91e329a37ca6924ecb8e00285c1509b'],
          ];
          $total_rev = 0;
          foreach ( $fb_hyros as $fb_hyros_row){
              if($row == $fb_hyros_row['account_id']) {
                  $ad_set_url = 'https://graph.facebook.com/v15.0/act_'.$row.'/adsets?access_token='.$access_token;
                  $ad_set =Http::get($ad_set_url);
                  $ad_set_id = json_decode($ad_set->getBody()->getContents())->data;
                  foreach($ad_set_id as $as_set_row){
                      $get_hyros_data = Http::withHeaders([
                          'Content-Type' => 'application/json',
                          'API-Key' => $fb_hyros_row['api_key'], 
                      ])->get('https://api.hyros.com/v1/api/v1.0/attribution', [
                          "attributionModel" => 'last_click',
                          "startDate" => $this_year.'-'.$this_month.'-01',
                          "endDate" => $this_year.'-'.$this_month.'-'.$today,
                          'currency' => 'user_currency',
                          "level" => 'facebook_adset',
                          "fields" => 'revenue, sales, total_revenue',
                          "ids" => $as_set_row->id,
                          "dayOfAttribution" => false,
                      ]);
                      if($get_hyros_data->getStatusCode() == 200){
                          $data = json_decode($get_hyros_data->getBody()->getContents());
                          // dd($data->result[0]->revenue);
                          $total_rev += $data->result[0]->revenue;
                      }
                  }
                 
              }
              $individual_acc_arr['MTD_Sales'] = (float)$total_rev;
          }
          array_push($total_account_arr, $individual_acc_arr);
      }
      dd($total_account_arr);
      // Airtable API initialization
      $apiKey = env("AIRTABLE_KEY");
      $database = env("AIRTABLE_BASE");
      $tableName = 'FB_Ads_MTD_Cost';
      $client = new \Zadorin\Airtable\Client($apiKey, $database);
      
      // Remove Old Data
      $query = $client->table($tableName)
          ->select('*')
          ->paginate(100);
      
      $total_old_arr = array();

      while ($recordset = $query->nextPage()) {
          $temp_arr = $recordset->fetchAll();
          array_push($total_old_arr, ...$temp_arr);
      }

      try{
          foreach ($total_old_arr as $toa){
              $client->delete($toa)->execute();
              usleep(250000);

          }
      }
      catch (Exception $err){
          $x = "Nothing";
      }
      
      // Insert new data to Airtable

      foreach ($total_account_arr as $taa){
          $client->table($tableName)
                  ->insert($taa)
                  ->execute();
                  usleep(250000);
      }
      
  }
}
