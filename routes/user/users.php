<?php

use App\Http\Controllers\User as UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/allusers',[UserController::class,'getUsers']);
Route::get('/user/{id}',[UserController::class,'getSpecificUser']);
Route::post('/createuser',[UserController::class,'createUser']);
Route::post('/updateuser/{id}',[UserController::class,'updateUser']);
Route::post('/deleteuser/{id}',[UserController::class,'deleteUser']);
Route::name('verify')->get('/verifyuser/{token}',[UserController::class,'verifyUser']);
Route::name('resend')->get('/{id}/resend',[UserController::class,'resend']);
