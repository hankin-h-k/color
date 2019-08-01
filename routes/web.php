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
// Route::post('wechat/mobile', 'Auth\LoginController@getPhone');
// Route::get('send/code', 'HomeController@sendCode');

Route::middleware('auth')->group(function () {
	
});
Route::get('test', 'Controller@test');
Route::get('detect', 'DetectionsController@detect');