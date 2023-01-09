<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoogleHyros;

class GoogleAdsController extends Controller
{
    public function index(Request $request){
        $data = GoogleHyros::orderBy('updated_at', 'DESC')->get();
        return view('admin.pages.google_ads.index', [
            'data' => $data,
        ]);
    }

    public function edit(Request $request){
        $data= GoogleHyros::findOrFail($request->id);
        return response()->json(['result' => $data]);
    }

    public function update(Request $request){
        $hyros= GoogleHyros::findOrFail($request->id);
        $hyros->name = $request->name;
        $hyros->email = $request->email;
        $hyros->account_id = $request->account_id;
        $hyros->api_key = $request->api_key;
        $hyros->update();
        return response()->json(['result' => 'success']);
    }

    public function store(Request $request){
        $hyros = new GoogleHyros;
        $hyros->name = $request->name;
        $hyros->email = $request->email;
        $hyros->account_id = $request->account_id;
        $hyros->api_key = $request->api_key;
        $hyros->save();
        return response()->json(['result' => 'success']);
    }

    public function status(Request $request){
        $hyros = GoogleHyros::where('id', $request->id)
                                ->update([
                                    'status' => toBoolean($request->status),
                                ]);
        return response()->json(['result' => 'success']);
    }
    
    public function delete(Request $request){
        $hyros = GoogleHyros::findOrFail($request->id);
        $hyros->delete();
        return response()->json(['result' => 'success']);
    }
}
