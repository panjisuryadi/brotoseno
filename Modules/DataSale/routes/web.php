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
    $module_name = 'datasale';
    $controller_name = 'DataSalesController';


    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
  


    Route::post("$module_name/updateincentive", ['as' => "$module_name.updateincentive", 'uses' => "$controller_name@updateincentive"]);
    Route::post("$module_name/updatetarget", ['as' => "$module_name.updatetarget", 'uses' => "$controller_name@updatetarget"]);
    Route::get("$module_name/show_data/{detail}", ['as' => "$module_name.show_data", 'uses' => "$controller_name@show_data"]);
    Route::get("$module_name/show_stock/{detail}", ['as' => "$module_name.show_stock", 'uses' => "$controller_name@show_stock"]);
    Route::get("$module_name/edit-insentif", ['as' => "$module_name.edit_insentif", 'uses' => "$controller_name@edit_insentif"]);
    Route::patch("$module_name/update_json", ['as' => "$module_name.update_json", 'uses' => "$controller_name@update_json"]);


    //data laporan sales
    Route::get("$module_name/laporan-sales", ['as' => "$module_name.laporan_sales", 'uses' => "LaporanSalesController@index"]);


    Route::resource("$module_name", "$controller_name");

});


