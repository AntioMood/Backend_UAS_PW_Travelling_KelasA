<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();

});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::get('users/{id}', 'Api\UserController@show');
Route::put('users/{id}', 'Api\UserController@update');
Route::apiResource('/tempat_wisatas', App\Http\Controllers\TempatWisataController::class);
Route::apiResource('/tikets', App\Http\Controllers\TiketController::class);
Route::apiResource('/trips', App\Http\Controllers\TripController::class);
Route::apiResource('/hotels', App\Http\Controllers\HotelController::class);
