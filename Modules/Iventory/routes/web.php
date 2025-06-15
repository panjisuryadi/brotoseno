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
    $module_name = 'iventory';
    $controller_name = 'IventoriesController';

      Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

      Route::get("$module_name/kategori/{id}", ['as' => "$module_name.kategori", 'uses' => "$controller_name@kategori"]);

     Route::get("$module_name/type/{type}", ['as' => "$module_name.type", 'uses' => "$controller_name@type"]);

      Route::get("$module_name/distribusi/{distribusi}", ['as' => "$module_name.distribusi", 'uses' => "$controller_name@distribusi"]);
      Route::resource("$module_name", "$controller_name");

});


