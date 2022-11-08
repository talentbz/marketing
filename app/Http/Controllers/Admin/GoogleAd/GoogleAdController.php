<?php

namespace App\Http\Controllers\Admin\GoogleAd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelAds;

class GoogleAdController extends Controller
{
    public function index(Request $request)
    {
        $googleAds = LaravelAds::googleAds()->with('ACCOUNT_ID');
        $campaigns = $googleAds->fetch()->getCampaigns();

        dd($campaigns);
    }
}
