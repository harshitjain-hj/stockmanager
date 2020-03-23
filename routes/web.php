<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// All customer routes
Route::resource('/customer', 'CustomerController')->middleware('auth');

Route::resource('/item', 'ItemController')->middleware('auth');