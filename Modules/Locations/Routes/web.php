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
Route::group(['middleware' => 'auth'], function () {
    $module_name = 'locations';
    $controller_name = 'LocationsController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

    Route::get("$module_name/parent/{parent}", ['as' => "$module_name.getParent", 'uses' => "$controller_name@getParent"]);
    Route::get("$module_name/getone/{id}", ['as' => "$module_name.getone", 'uses' => "$controller_name@getone"]);
    Route::resource("$module_name", "$controller_name");

});


