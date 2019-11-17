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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/ocr/lineoa', 'OcrController@store2');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('ocr', 'OcrController');
    Route::resource('profile', 'ProfileController');
});

