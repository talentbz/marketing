<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelAds;

class FbApiController extends Controller
{
    public function getMTD( Request $request){
        $facebookAds = LaravelAds::facebookAds()->with(806688472849920);
        $campaigns = $facebookAds->fetch()->getCampaigns();
        dd($campaigns);
    }
}
