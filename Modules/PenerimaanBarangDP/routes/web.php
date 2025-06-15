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
    $module_name = 'penerimaanbarangdp';
    $controller_name = 'PenerimaanBarangDPsController';
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/{item}/print/", ['as' => "$module_name.print", 'uses' => "PenerimaanBarangDPsController@print"]);  
    Route::get("$module_name/payment", ['as' => "$module_name.payment", 'uses' => "PenerimaanBarangDPsController@payment"]);
    Route::get("$module_name/index_data_payment", ['as' => "$module_name.index_data_payment", 'uses' => "$controller_name@index_data_payment"]);
    Route::get("$module_name/{id}/edit_payment", ['as' => "$module_name.edit_payment", 'uses' => "$controller_name@edit_payment"]);
    Route::post("$module_name/update_payment/", ['as' => "$module_name.update_payment", 'uses' => "$controller_name@update_payment"]);
    Route::get("$module_name/payment_detail/print/{detail}", ['as' => "$module_name.payment_detail.print", 'uses' => "$controller_name@payment_detail_print"]);
    Route::resource("$module_name", "$controller_name");

});


