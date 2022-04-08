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

Route::prefix('thermalprinterpro')->group(function() {
    Route::get('/settings', 'ThermalPrinterProController@index');
    Route::get('/orderp/{order_id}', 'ThermalPrinterProController@printOrder')->name('restaurant.printOrder');
});
