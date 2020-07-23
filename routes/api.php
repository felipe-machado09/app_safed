<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::middleware('auth:api')->get('/auth/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api','prefix' => 'barcode'], function() {
    Route::get('/', 'BarCodeController@index');
    Route::post('/', 'BarCodeController@store');
    Route::get('/export/yesterday', 'BarCodeController@ExportExcelYesterday');
    Route::get('/export/today', 'BarCodeController@ExportExcelToday');
    Route::get('/export/week', 'BarCodeController@ExportExcelWeek');
    Route::get('/export/month', 'BarCodeController@ExportExcelMonth');
    Route::get('/export/interval', 'BarCodeController@ExportExcelInterval');

});
Route::group(['middleware' => 'auth:api','prefix' => 'user'], function() {
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@store');
    Route::put('/{id}', 'UserController@update');
    Route::delete('/{id}', 'UserController@destroy');
});
