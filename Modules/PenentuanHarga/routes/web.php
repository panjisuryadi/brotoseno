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
    $module_name = 'penentuanharga';
    $controller_name = 'PenentuanHargasController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

    Route::get("$module_name/setting", ['as' => "$module_name.setting", 'uses' => "$controller_name@setting"]);


   Route::get("$module_name/index_setting", ['as' => "$module_name.index_setting", 'uses' => "$controller_name@index_setting"]);


    Route::resource("$module_name", "$controller_name");

});


