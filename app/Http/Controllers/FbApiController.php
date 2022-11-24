<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelAds;

class FbApiController extends Controller
{
    public function getMTD( Request $request){
        $facebookAds = LaravelAds::facebookAds()->with('ACCOUNT_ID');
        dd($facebookAds);
    }
}
