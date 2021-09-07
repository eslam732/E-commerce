<?php

use App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/allsellers',[Seller::class,'getSellers']);
Route::get('/seller/{id}',[Seller::class,'getSeller']);
Route::get('/{id}/transactions',[Seller::class,'sellerTranasctions']);
Route::get('/{id}/categories',[Seller::class,'sellerCategories']);
Route::get('/{id}/buyers',[Seller::class,'sellerBuyers']);
Route::get('/{id}/products',[Seller::class,'sellerProducts']);
Route::post('/{id}/createproduct',[Seller::class,'createProduct']);
