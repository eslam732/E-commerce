<?php

use App\Http\Controllers\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/all', [Product::class, 'getAll']);
Route::get('/{id}', [Product::class, 'getOne']);
Route::get('/{id}/transactions', [Product::class, 'productTransaction']);
Route::get('/{id}/buyers', [Product::class, 'productBuyers']);
Route::get('/{id}/categories', [Product::class, 'productCategories']);
Route::put('/updatecategories/{productId}/{categoryId}', [Product::class, 'addCategoryToProduct']);
Route::put('removecategory/{productId}/{categoryId}/', [Product::class, 'removeCategoryFromProduct']);
// Route::post('/create',[Product::class,'createCat']);
// Route::post('/update/{id}', [Product::class, 'update']);
//Route::delete('/delete/{id}', [Product::class, 'delete']);

