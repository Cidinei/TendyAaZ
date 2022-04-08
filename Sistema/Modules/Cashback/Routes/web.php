<?php

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

Route::prefix('cashback')->group(function() {
    Route::get('/', 'CashbackController@index')->name('cashback.index');
    Route::get('/settings', 'CashbackController@settings')->name('cashback.settings');
    Route::post('/setting/store', 'CashbackController@store')->name('cashback.settings.store');
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/cashback/reports', 'CashbackController@adminReports')->name('admin.cashback.reports');
});

Route::group(['prefix' => 'store-owner', 'middleware' => 'storeowner'], function () {
    Route::get('/cashback/reports', 'CashbackController@reports')->name('cashback.reports');
});
