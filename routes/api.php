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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('ocr', 'API\OcrController');
Route::resource('location', 'API\LocationController');
Route::get('/map/locations','API\MapController@locations');
Route::get('/map/staffgauges','API\MapController@staffgauges');
Route::get('/map/ocrs','API\MapController@ocrs');
Route::post('/updateocr', 'API\OcrController@updateocrs');