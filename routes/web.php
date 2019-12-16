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
    Route::resource('dashboard', 'DashboardController');
});

Route::prefix('login')->group(function () {
    Route::get('/line', 'Auth\LoginController@redirectToProvider')->name('login.provider');
    Route::get('/line/callback', 'Auth\LoginController@handleProviderCallback')->name('login.provider.callback');
});


Route::resource('log-ocr', 'LogOcrController');
Route::resource('my-log-ocr', 'MyLogOcrController');