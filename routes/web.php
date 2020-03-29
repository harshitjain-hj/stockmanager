<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Stock Routes
    // All item routes
    Route::resource('/item', 'Stock\ItemController')->middleware('auth');

    Route::get('/lorryinfo', 'Stock\LorryInfoController@index')->middleware('auth');

    // All stock routes
    Route::resource('/stock', 'Stock\StockController')->middleware('auth');

// Sales Routes
    // All customer routes
    Route::resource('/customer', 'Sale\CustomerController')->middleware('auth');

    // All sales routes 
    Route::resource('/sale', 'Sale\SaleController')->middleware('auth');

    // All customer report routes 
    Route::resource('/repo', 'Sale\CustomerRepoController')->middleware('auth');