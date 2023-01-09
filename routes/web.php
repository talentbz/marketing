<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/**
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// Route::get(
//     '/',
//     function () {
//         return view('main');
//     }
// );
Route::post(
    'pause-campaign',
    'GoogleAdsApiController@pauseCampaignAction'
);
Route::match(
    ['get', 'post'],
    'show-report',
    'GoogleAdsApiController@showReportAction'
);

Route::get(
    'get_cost',
    'GoogleAdsApiController@getCost'
);

Route::get(
    'get_mtd',
    'GoogleAdsApiController@getMTD'
);

Route::get(
    'get_hyros',
    'HyrosApiController@getMTD'
);

Route::get(
    'get_fb',
    'FbApiController@getMTD'
);

Route::get(
    'get_klaviyo',
    'KlApiController@getMTD'
);

Route::get(
    'get_tt_auth_code',
    "TikController@getAuthCode"
);

Route::get(
    'get_tt',
    "TikController@getMTD"
);
Auth::routes();
Route::middleware(['auth:web'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
    Route::prefix('/shopify')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ShopifyController::class, 'index'])->name('admin.shopify.index');
        Route::post('/store', [App\Http\Controllers\Admin\ShopifyController::class, 'store'])->name('admin.shopify.store');
        Route::get('/edit', [App\Http\Controllers\Admin\ShopifyController::class, 'edit'])->name('admin.shopify.edit');
        Route::post('/update', [App\Http\Controllers\Admin\ShopifyController::class, 'update'])->name('admin.shopify.update');
        Route::get('/status', [App\Http\Controllers\Admin\ShopifyController::class, 'status'])->name('admin.shopify.status');
        Route::post('/delete', [App\Http\Controllers\Admin\ShopifyController::class, 'delete'])->name('admin.shopify.delete');
    });
});

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
