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
    $module_name = 'goodsreceiptberlian';
    $controller_name = 'GoodsReceiptBerliansController';
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/qc", ['as' => "$module_name.qc.index", 'uses' => "$controller_name@indexqc"]);
    Route::get("$module_name/create-qc", ['as' => "$module_name.createqc", 'uses' => "$controller_name@create_qc"]);
    Route::get("$module_name/{id}/edit-qc", ['as' => "$module_name.qc.edit", 'uses' => "$controller_name@edit_qc"]);
    Route::get("$module_name/{id}/show-qc", ['as' => "$module_name.qc.show", 'uses' => "$controller_name@show_qc"]);
    Route::post("$module_name/store-qc", ['as' => "$module_name.qc.store", 'uses' => "$controller_name@store_qc"]);
    Route::post("$module_name/update-qc", ['as' => "$module_name.qc.update", 'uses' => "$controller_name@update_qc"]);
    
    // Debts
    Route::get("$module_name/debts", ['as' => "$module_name.debts", 'uses' => "$controller_name@debts"]);
    Route::get("$module_name/debts-data", ['as' => "$module_name.debts_data", 'uses' => "$controller_name@debts_data"]);

    Route::resource("$module_name", "$controller_name");

});


