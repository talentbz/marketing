<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('get_mtd', [App\Http\Controllers\GoogleAdsApiController::class, 'getMTD']);
Route::get('get_fb', [App\Http\Controllers\FbApiController::class, 'getMTD']);
Route::get('get_klaviyo', [App\Http\Controllers\KlApiController::class, 'getMTD']);
Route::get('get_tt', [App\Http\Controllers\TikController::class, 'getMTD']);

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
    Route::prefix('/google')->group(function () {
        Route::prefix('/hyros')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\GoogleAdsController::class, 'index'])->name('admin.google-hyros.index');
            Route::post('/store', [App\Http\Controllers\Admin\GoogleAdsController::class, 'store'])->name('admin.google-hyros.store');
            Route::get('/edit', [App\Http\Controllers\Admin\GoogleAdsController::class, 'edit'])->name('admin.google-hyros.edit');
            Route::post('/update', [App\Http\Controllers\Admin\GoogleAdsController::class, 'update'])->name('admin.google-hyros.update');
            Route::get('/status', [App\Http\Controllers\Admin\GoogleAdsController::class, 'status'])->name('admin.google-hyros.status');
            Route::post('/delete', [App\Http\Controllers\Admin\GoogleAdsController::class, 'delete'])->name('admin.google-hyros.delete');
        });
    });
});

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
