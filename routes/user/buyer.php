<?php

use App\Http\Controllers\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/allbuyers',[Buyer::class,'getBuyers']);
Route::get('/{id}',[Buyer::class,'getBuyer']);
Route::get('/{id}/transactions',[Buyer::class,'buyerTransactions']);
Route::get('/{id}/products',[Buyer::class,'buyerProducts']);
Route::get('/{id}/seller',[Buyer::class,'sellersForBuyer']);
Route::get('/{id}/categories',[Buyer::class,'categoriesForBuyer']);

