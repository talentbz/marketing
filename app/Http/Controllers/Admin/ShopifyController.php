<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    public function index(Request $request){
        // $airline = AirLine::get();
        return view('admin.pages.shopify.index', [
            // 'airline' => $airline,
        ]);
    }
    public function edit(Request $request, $id){
        
    }
    public function update(Request $request, $id){
        
    }
    public function store(Request $request){
        
    }
}
