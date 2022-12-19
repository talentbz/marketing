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

        $fb_adset_id = ['23849866626640128'];
        $total_rev = 0;
        foreach ( $fb_adset_id as $row){
            $get_hyros_data = Http::withHeaders([
                'Content-Type' => 'application/json',
                'API-Key' => '3d1cb41817d5eaf00a6479a312af70e68893f1700c4aa3501a279a1b40326096', 
            ])->get('https://api.hyros.com/v1/api/v1.0/attribution', [
                "attributionModel" => 'last_click',
                "startDate" => '2022-12-01',
                "endDate" => '2022-12-19',
                'currency' => 'user_currency',
                "level" => 'facebook_ad',
                "fields" => 'revenue, sales, total_revenue',
                "ids" => $row,
                "dayOfAttribution" => false,
            ]);
            if($get_hyros_data->getStatusCode() == 200){
                $data = json_decode($get_hyros_data->getBody()->getContents());
                // dd($data->result[0]->revenue);
                $total_rev += $data->result[0]->revenue;
            }
        }
        dd($total_rev);
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
            $individual_acc_arr['FB_Account_ID'] = $row;
            
            // get account data
            $account_url = 'https://graph.facebook.com/v15.0/act_'.$row.'?fields=name&access_token='.$access_token;
            $account_response =Http::get($account_url);
            $account_name = json_decode($account_response->getBody()->getContents())->name;
            $individual_acc_arr['Store_Name'] = $account_name;
            
            //get mtd data
            $mtd_url = 'https://graph.facebook.com/v15.0/act_'.$row.'/insights?date_preset='.$date_preset.'&access_token='.$access_token;
            $mtd_response =Http::get($mtd_url);
            $mtd_data = json_decode($mtd_response->getBody()->getContents());
            $mtd = 0;
            if($mtd_data->data && $mtd_data->data[0] && $mtd_data->data[0]->spend){
                $mtd = $mtd_data->data[0]->spend;
            }
            $individual_acc_arr['MTD_Cost'] = (float)$mtd;
            array_push($total_account_arr, $individual_acc_arr);
        }
        
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
