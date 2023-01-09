<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shopify;

class ShopifyController extends Controller
{
    public function index(Request $request){
        $data = Shopify::get();
        return view('admin.pages.shopify.index', [
            'data' => $data,
        ]);
    }

    public function edit(Request $request){
        $data= Shopify::findOrFail($request->id);
        return response()->json(['result' => $data]);
    }

    public function update(Request $request){
        $shopify= Shopify::findOrFail($request->id);
        $shopify->name = $request->store_name;
        $shopify->url = $request->store_url;
        $shopify->access_token = $request->access_token;
        $shopify->update();
        return response()->json(['result' => 'success']);
    }

    public function store(Request $request){
        $shopify = new Shopify;
        $shopify->name = $request->store_name;
        $shopify->url = $request->store_url;
        $shopify->access_token = $request->access_token;
        $shopify->save();
        return response()->json(['result' => 'success']);
    }

    public function status(Request $request){
        $shopify = Shopify::where('id', $request->id)
                                ->update([
                                    'status' => toBoolean($request->status),
                                ]);
        return response()->json(['result' => 'success']);
    }
    
    public function delete(Request $request){
        $shopify = Shopify::findOrFail($request->id);
        $shopify->delete();
        return response()->json(['result' => 'success']);
    }
}
