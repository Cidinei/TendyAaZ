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

Route::prefix('storedashboardpro')->group(function() {
    Route::get('/settings', 'StoreDashBoardProController@index');
    Route::get('/orders/mark-order-send/{id}', 'StoreDashBoardProController@markOrderSend')->name('restaurant.markOrderSend');
});
