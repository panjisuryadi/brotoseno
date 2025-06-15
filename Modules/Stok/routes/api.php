<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Stok\Http\Controllers\StoksController;

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

Route::middleware('auth:static.api.token')->get('/stoks', function (Request $request) {
    return $request->user();
});

Route::middleware('api_token')->post('/lantakan/create',  [StoksController::class, 'lantakanApiStore']);


