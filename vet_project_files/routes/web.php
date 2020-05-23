<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "Home@index");

// /owners
Route::group(["prefix" => "owners"], function () {
    // All owners display
    Route::get('/', "Owners@index");
    
    // Only logged in users
    Route::group(["middleware"=> "auth"], function () {

        // Owner Entry
        Route::get('/create', "Owners@create");
        Route::post('/create', "Owners@createOwner");
    
        // Owner Edit
        Route::get('/edit/{owner}', "Owners@edit");
        Route::post('/edit/{owner}', "Owners@editOwner");
    
        // single owner display, add Animal on owner page
        Route::post('/{owner}', "Owners@addAnimal");
    });
    Route::get('/{owner}', "Owners@show");
});

// Animals
Route::group(["prefix" => "animals"], function () {
    Route::get('/', "Animals@index");
    Route::get('/{animal}', "Animals@show");
});

Auth::routes(['register' => false]);

Route::get('/home', "Home@index")->name('home');
