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

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    $module_name = 'distribusitoko';
    $controller_name = 'DistribusiTokosController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

     Route::get("$module_name/index_data_table", ['as' => "$module_name.index_data_table", 'uses' => "$controller_name@index_data_table"]);

     Route::get("$module_name/index_data_complete", ['as' => "$module_name.index_data_complete", 'uses' => "$controller_name@index_data_complete"]);

    

    Route::get("$module_name/detail/{dist_toko}", ['as' => "$module_name.detail", 'uses' => "$controller_name@detail"]);




    Route::get("$module_name/cetak/{dist_toko}", ['as' => "$module_name.cetak", 'uses' => "$controller_name@cetak"]);


    

        Route::get("$module_name/show_distribusi/{id}", ['as' => "$module_name.show_distribusi", 'uses' => "$controller_name@show_distribusi"]);

    

  Route::get("$module_name/export-detail-emas/{dist_toko}", ['as' => "$module_name.export_emas_detail", 'uses' => "$controller_name@export_emas_detail"]);



  Route::get("$module_name/view-excel/{dist_toko}", ['as' => "$module_name.view_excel", 'uses' => "$controller_name@view_excel"]);



  Route::get("$module_name/detail-distribusi/{dist_toko}", ['as' => "$module_name.detail_distribusi", 'uses' => "$controller_name@detail_distribusi"]);




  Route::get("$module_name/view-distribusi/{id}", ['as' => "$module_name.view_distribusi", 'uses' => "$controller_name@view_distribusi"]);


  Route::get("$module_name/tracking-distribusi/{dist_toko}", ['as' => "$module_name.tracking", 'uses' => "$controller_name@tracking"]);



    Route::post("$module_name/approve-distribusi/{id}", ['as' => "$module_name.approve_distribusi", 'uses' => "$controller_name@approve_distribusi"]);


    

    Route::get("$module_name/kategori/{slug}", ['as' => "$module_name.kategori", 'uses' => "$controller_name@kategori"]);

  // Route::get("$module_name/cetak/{id}", ['as' => "$module_name.cetak", 'uses' => "$controller_name@cetak"]);


    Route::get("$module_name/send/{dist_toko}", ['as' => "$module_name.send", 'uses' => "$controller_name@send"]);

    Route::get("$module_name/berlian/create", ['as' => "$module_name.berlian.create", 'uses' => "$controller_name@create_berlian"]);
    Route::get("$module_name/berlian", ['as' => "$module_name.berlian", 'uses' => "$controller_name@index_berlian"]);
    Route::get("$module_name/index_data_berlian", ['as' => "$module_name.index_data_berlian", 'uses' => "$controller_name@index_data_berlian"]);


    // Emas
    Route::get("$module_name/emas/create", ['as' => "$module_name.emas.create", 'uses' => "$controller_name@create_emas"]);

    Route::get("$module_name/emas/edit/{dist_toko}", ['as' => "$module_name.emas.edit", 'uses' => "$controller_name@edit_emas"]);


    Route::get("$module_name/emas", ['as' => "$module_name.emas", 'uses' => "$controller_name@index_emas"]);

    Route::get("$module_name/index_data_emas", ['as' => "$module_name.index_data_emas", 'uses' => "$controller_name@index_data_emas"]);

    Route::get("$module_name/export_emas", ['as' => "$module_name.export_emas", 'uses' => "$controller_name@export_emas"]);



    Route::resource("$module_name", "$controller_name");


});


