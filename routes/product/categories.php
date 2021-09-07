<?php

use App\Http\Controllers\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/all', [Category::class, 'getcategories']);
Route::get('/{id}', [Category::class, 'getSpecificCat']);
Route::post('/create',[Category::class,'createCat']);
Route::post('/update/{id}', [Category::class, 'update']);
Route::delete('/delete/{id}', [Category::class, 'delete']);
Route::get('/{id}/products', [Category::class, 'productsForCategory']);
Route::get('/{id}/sellers', [Category::class, 'sellersForCategory']);
Route::get('/{id}/transactions', [Category::class, 'transactionsForCategory']);
Route::get('/{id}/buyers', [Category::class, 'buyersForCategory']);


