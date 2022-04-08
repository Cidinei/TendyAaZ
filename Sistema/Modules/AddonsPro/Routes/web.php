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

Route::prefix('addonspro')->group(function() {
    Route::get('/', 'AddonsProController@index');
    Route::get('/settings', 'AddonsProController@settings');
    Route::get('/addoncategory/disablerequired/{id}', 'AddonsProController@disableRequiredAddonCategory');
});
