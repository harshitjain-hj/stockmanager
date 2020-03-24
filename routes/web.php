<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// All customer routes
Route::resource('/customer', 'CustomerController')->middleware('auth');

// All item routes
Route::resource('/item', 'ItemController')->middleware('auth');

// All sales routes 
Route::resource('/sale', 'SaleController')->middleware('auth');

// All customer report routes 
Route::resource('/repo', 'CustomerRepoController')->middleware('auth');