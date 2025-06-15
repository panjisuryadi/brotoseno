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
    $module_name = 'stok';
    $controller_name = 'StoksController';

    Route::get("$module_name/get_stock_pending", ['as' => "$module_name.get_stock_pending", 'uses' => "$controller_name@get_stock_pending"]);

    Route::get("$module_name/get_stock_pending_office", ['as' => "$module_name.get_stock_pending_office", 'uses' => "$controller_name@get_stock_pending_office"]);

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

   Route::get("$module_name/nolate", ['as' => "$module_name.nolate", 'uses' => "$controller_name@nolate"]);


 Route::get("$module_name/office", ['as' => "$module_name.office", 'uses' => "$controller_name@office"]);

 Route::get("$module_name/index_data_office", ['as' => "$module_name.index_data_office", 'uses' => "$controller_name@index_data_office"]);

 Route::get("$module_name/office/{office}", ['as' => "$module_name.gudang-office.detail", 'uses' => "$controller_name@gudang_office_detail"]);




 Route::get("$module_name/pending", ['as' => "$module_name.pending", 'uses' => "$controller_name@pending"]);

 Route::get("$module_name/export-excel", ['as' => "$module_name.export_excel", 'uses' => "$controller_name@export_excel"]);


Route::get("$module_name/pending/{id}", ['as' => "$module_name.view_pending", 'uses' => "$controller_name@view_pending"]);

 Route::get("$module_name/index_data_pending", ['as' => "$module_name.index_data_pending", 'uses' => "$controller_name@index_data_pending"]);


Route::get("$module_name/pending-office", ['as' => "$module_name.pending_office", 'uses' => "$controller_name@pending_office"]);
Route::get("$module_name/pending-office/{id}", ['as' => "$module_name.view_pending_office", 'uses' => "$controller_name@view_pending_office"]);
Route::get("$module_name/index_data_pending_office", ['as' => "$module_name.index_data_pending_office", 'uses' => "$controller_name@index_data_pending_office"]);
Route::get("$module_name/show_pending_office/{categoryName}/{karatName}", ['as' => "$module_name.show_pending_office", 'uses' => "$controller_name@show_pending_office"]);

// READY OFFICE
Route::get("$module_name/ready-office", ['as' => "$module_name.ready_office", 'uses' => "$controller_name@ready_office"]);
Route::get("$module_name/index_data_ready_office", ['as' => "$module_name.index_data_ready_office", 'uses' => "$controller_name@index_data_ready_office"]);
Route::get("$module_name/get_stock_ready_office", ['as' => "$module_name.get_stock_ready_office", 'uses' => "$controller_name@get_stock_ready_office"]);

// READY CABANG
Route::get("$module_name/ready", ['as' => "$module_name.ready", 'uses' => "$controller_name@ready"]);
Route::get("$module_name/berlian/ready", ['as' => "$module_name.berlian.ready", 'uses' => "$controller_name@berlian_ready"]);
Route::get("$module_name/index_data_ready", ['as' => "$module_name.index_data_ready", 'uses' => "$controller_name@index_data_ready"]);
Route::get("$module_name/get_stock_ready", ['as' => "$module_name.get_stock_ready", 'uses' => "$controller_name@get_stock_ready"]);


 Route::get("$module_name/sales", ['as' => "$module_name.sales", 'uses' => "$controller_name@sales"]);

 Route::get("$module_name/index_data_sales", ['as' => "$module_name.index_data_sales", 'uses' => "$controller_name@index_data_sales"]);



 Route::get("$module_name/dp", ['as' => "$module_name.dp", 'uses' => "$controller_name@dp"]);

 Route::get("$module_name/index_data_dp", ['as' => "$module_name.index_data_dp", 'uses' => "$controller_name@index_data_dp"]);



 Route::get("$module_name/lantakan", ['as' => "$module_name.lantakan", 'uses' => "$controller_name@lantakan"]);

 Route::get("$module_name/index_data_lantakan", ['as' => "$module_name.index_data_lantakan", 'uses' => "$controller_name@index_data_lantakan"]);

 Route::get("$module_name/rongsok", ['as' => "$module_name.rongsok", 'uses' => "$controller_name@rongsok"]);

 Route::get("$module_name/index_data_rongsok", ['as' => "$module_name.index_data_rongsok", 'uses' => "$controller_name@index_data_rongsok"]);






    Route::resource("$module_name", "$controller_name");

});


