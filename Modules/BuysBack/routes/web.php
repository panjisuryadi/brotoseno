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

    $module_name = 'buysback';
    $controller_name = 'BuysBacksController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/office/index_data", ['as' => "$module_name.office.index_data", 'uses' => "Office\BuyBackController@index_data"]);
    Route::patch("$module_name/nota-process", ['as' => "$module_name.nota.process", 'uses' => "Office\BuyBackController@process"]);

    Route::get("$module_name/index_buyback_item_data", ['as' => "$module_name.index_buyback_item_data", 'uses' => "$controller_name@index_buyback_item_data"]);
    Route::get("$module_name/index_buyback_nota_data", ['as' => "$module_name.index_buyback_nota_data", 'uses' => "$controller_name@index_buyback_nota_data"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/buysback-nota", ['as' => "$module_name.buysback_nota", 'uses' => "$controller_name@buysback_nota"]);
    //save type
    Route::post('buys-back/save-customer', 'BuysBacksController@saveTypeCustomer')->name('buysback.save.customer'); 
    Route::patch('buys-back/update-status/{id}', 'BuysBacksController@update_status')->name('buysback.update_status');



    Route::get('/buysback-status/{id}', 'BuysBacksController@status')->name('buysback.status');

    //buys back nota
    Route::get('/buysback-nota/index_data', 'BuysBackNotaController@index_data')
             ->name('buysback.nota.index_data');


    Route::resource("$module_name", "$controller_name");

});


