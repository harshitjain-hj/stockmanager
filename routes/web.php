<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Auth::routes(['register' => false]);

// for employee + admin users
Route::middleware('can:create-vouchers')->group(function(){
	Route::get('/voucherlist', 'Voucher\VoucherController@index')->name('voucherlist');
    Route::get('/customerlist', 'Voucher\VoucherController@customerList')->name('customerlist');
    Route::get('/customerlist/{id}', 'Voucher\VoucherController@option')->name('option');
	Route::post('/voucher/{id}/verified', 'Voucher\VoucherController@verified')->name('verified');
	Route::post('/voucher/{id}/rejected', 'Voucher\VoucherController@rejected')->name('rejected');
	Route::get('/summary', 'Voucher\VoucherController@summary')->name('summary');

    // sales
    Route::get('/customerlist/{id}/sale', 'Voucher\VoucherController@sale')->name('option.sale');
    Route::post('/customerlist/{id}/generatesale', 'Voucher\VoucherController@generatesale')->name('generate.sale');
    Route::post('/customerlist/{id}/salerecite', 'Voucher\VoucherController@printsale')->name('print.sale');
    // recieve
    Route::get('/customerlist/{id}/recieve', 'Voucher\VoucherController@recieve')->name('option.recieve');
    Route::post('/customerlist/{id}/recieverecite', 'Voucher\VoucherController@printrecieve')->name('print.recieve');
});

// for admin users
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
});

Route::middleware('can:manage-users')->group(function(){

    Route::get('/home', 'HomeController@index')->name('home')->middleware('can:manage-users');

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
        Route::get('/sale/receive', 'Sale\SaleController@receive')->name('sale.receive')->middleware('auth');
        Route::get('/sale/delete/{id}', 'Sale\SaleController@destroy')->name('sale.delete')->middleware('auth');
        Route::resource('/sale', 'Sale\SaleController')->middleware('auth');

        // All customer report routes
        Route::resource('/repo', 'Sale\CustomerRepoController')->middleware('auth');

    // Store Routes
        Route::resource('/store', 'Store\StoreController')->middleware('auth');

        Route::get('/store/create_more/{store_id}', 'Store\StoreController@create_more')->name('store.create_more')->middleware('auth');

        Route::get('/store/withdraw/{id}', 'Store\StoreController@withdraw')->name('store.withdraw')->middleware('auth');

        Route::post('/store/withdraw/make', 'Store\StoreController@withdraw_update')->name('store.withdraw.update')->middleware('auth');

        // All withdraw routes
            Route::resource('/store/withdraw', 'Store\WithdrawController')->middleware('auth');
});
