<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HyrosApiController extends Controller
{
    public function getMTD( Request $request){
        return view('welcome');
        // $response = Http::get('https://private-ea0372-hyros.apiary-mock.com/v1/api/v1.0', [
        //     // "sessionId" => $sessionId,
        //     // "productId" => $productId,
        //     // "tokenId" => $tokenId,
        //     // "hotelId" => $hotelId,
        // ]);
        // $request->headers->set('Accept', 'application/json');
        // dd($response);
        // return json_decode($response);
    }
}
