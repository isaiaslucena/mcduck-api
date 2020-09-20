<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConverter;
use App\Http\Controllers\LogController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/health', function () {
	return response()->json("OK");
});

Route::get('/currencyList', [CurrencyConverter::class, 'currencyList']);

Route::get('/currencyConvert', [CurrencyConverter::class, 'currencyConvert']);

Route::get('/showConvertOperations', [LogController::class, 'index']);
