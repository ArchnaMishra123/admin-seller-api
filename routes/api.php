<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Seller\SellerAuthController;
use App\Http\Controllers\Seller\ProductController;

Route::post('admin/login',[AdminAuthController::class,'login']);

Route::middleware(['auth:api','role:ADMIN'])->group(function(){
    Route::post('admin/seller',[SellerController::class,'createSeller']);
    Route::get('admin/sellers',[SellerController::class,'listSellers']);
});

Route::post('seller/login',[SellerAuthController::class,'login']);

Route::middleware(['auth:api','role:SELLER'])->group(function(){
    Route::post('seller/products',[ProductController::class,'store']);
    Route::get('seller/products',[ProductController::class,'index']);
    Route::get('seller/products/{id}/pdf',[ProductController::class,'viewPdf']);
    Route::delete('seller/products/{id}',[ProductController::class,'destroy']);
});
