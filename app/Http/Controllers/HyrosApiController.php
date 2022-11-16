<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HyrosApiController extends Controller
{
    public function getMTD( Request $request){
        // return view('welcome');
        // $request = Http::get('https://private-ea0372-hyros.apiary-mock.com/v1/api/v1.0/attribution', [
        //     "attributionModel" => 'last_click',
        //     "startDate" => '2020-05-12T10:00:00',
        //     "endDate" => '2021-04-13T10:00:00',
        //     "level" => 'level',
        //     "fields" => 'fields',
        //     "ids" => '205044496234,205044496235',
        //     "dayOfAttribution" => false,
        //     "scientificDaysRange" => 30
        // ]);
        // $request->headers->set('Content-Type', 'application/json');
        // $request->headers->set('API-Key', 'b12a19f4521d44abc8d613efca7f9c23c88');
        // dd($request);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Key' => 'b12a19f4521d44abc8d613efca7f9c23c88', 
        ])->get('https://private-ea0372-hyros.apiary-mock.com/v1/api/v1.0/attribution', [
            "attributionModel" => 'last_click',
            "startDate" => '2020-05-12T10:00:00',
            "endDate" => '2021-04-13T10:00:00',
            "level" => 'level',
            "fields" => 'fields',
            "ids" => '205044496234,205044496235',
            "dayOfAttribution" => false,
            "scientificDaysRange" => 30
        ]);
        dd($response);
        return json_decode($response);
    }
}