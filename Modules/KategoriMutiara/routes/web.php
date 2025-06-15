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
    $module_name = 'kategorimutiara';
    $controller_name = 'KategoriMutiarasController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

     Route::get("$module_name/getid/{id}", ['as' => "$module_name.getid", 'uses' => "$controller_name@getByid"]);
    
    Route::resource("$module_name", "$controller_name");

});


