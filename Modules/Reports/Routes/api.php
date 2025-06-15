<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/reports', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api.key',
   ], function ($router) {
    Route::get('/reports/pembelian', 'Api\PembelianController@index');
    Route::get('/reports/sales-return-report', 'Api\SalesReturnController@index');
  
  
 });



