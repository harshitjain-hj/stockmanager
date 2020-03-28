<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Sales Routes
    // All customer routes
    Route::resource('/customer', 'Sale\CustomerController')->middleware('auth');

    // All item routes
    Route::resource('/item', 'Sale\ItemController')->middleware('auth');

    // All sales routes 
    Route::resource('/sale', 'Sale\SaleController')->middleware('auth');

    // All customer report routes 
    Route::resource('/repo', 'Sale\CustomerRepoController')->middleware('auth');