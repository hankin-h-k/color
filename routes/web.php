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
Route::post('wechat/mobile', 'Auth\LoginController@getPhone');
Route::get('send/code', 'HomeController@sendCode');

Route::middleware('auth')->group(function () {
	
	// Route::get('examp', 'Admin\DetectionsController@examples');
	// //详情
	// Route::get('examps/{example}', 'Admin\DetectionsController@example');
	// //添加
	// Route::get('examp', 'Admin\DetectionsController@storeExample');
	//修改
	// Route::get('examps/{example}', 'Admin\DetectionsController@updateExample');
	//删除
	Route::get('examps/{example}', 'Admin\DetectionsController@deleteExample');

});


Route::get('test', 'Controller@test');