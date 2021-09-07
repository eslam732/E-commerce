<?php

use App\Http\Controllers\CategoryTransaction;
use App\Http\Controllers\TransAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/all', [TransAction::class, 'getAll']);
Route::get('/{id}', [TransAction::class, 'getOne']);
Route::get('{id}/category', [CategoryTransaction::class, 'getOneCatT']);
Route::get('{id}/seller', [CategoryTransaction::class, 'getOneSeller']);

// Route::post('/create',[Product::class,'createCat']);
// Route::post('/update/{id}', [Product::class, 'update']);
//Route::delete('/delete/{id}', [Product::class, 'delete']);

