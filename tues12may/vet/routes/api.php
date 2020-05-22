<?php

use App\Http\Controllers\API\Animals;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["middleware" => ["auth:api"]], function () {
    // animals
    Route::group(["prefix" => "/animals"], function () {
        Route::get('/','API\Animals@index');
        Route::get('/{animal}','API\Animals@show');
        Route::delete('/{animal}','API\Animals@destroy');
        Route::post('/','API\Animals@store');
        Route::put('/{animal}','API\Animals@update');
    });

    // owners
    Route::group(["prefix" => "/owners"], function () {
        Route::get('/','API\Owners@index');
        Route::get('/{owner}','API\Owners@show');
        Route::delete('/{owner}','API\Owners@destroy');
        Route::post('/','API\Owners@store');
        Route::put('/{owner}','API\Owners@update');

        // owners/{owner_id}/animals
        Route::get('/{owner}/animals','API\Owners\Animals@show');
        Route::post('/{owner}/animals','API\Owners\Animals@store');
    });
});