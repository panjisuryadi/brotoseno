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
    $module_name = 'karat';
    $controller_name = 'KaratsController';
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/index_data_2", ['as' => "$module_name.index_data_2", 'uses' => "$controller_name@index_data_2"]);
    Route::patch("$module_name/update_coef/{data}", ['as' => "$module_name.update_coef", 'uses' => "$controller_name@update_coef"]);
    Route::resource("$module_name", "$controller_name");

});


