<?php

use Illuminate\Http\Request;

Route::post('login', 'Auth\LoginController@login');

Route::middleware('auth:api')->group(function () {
	/**
	 * 用户
	 */
	//用户列表
	Route::get('users', 'UsersController@users');
	//用户详情
	Route::get('users/{user}', 'UsersController@user');
	//用户测试列表
	Route::get('users/{user}/detections', 'UsersController@userDetctions');
	//通知用户
	// Route::post('inform/user/{user}', 'UsersController@informUser');
	// //屏蔽用户
	// Route::put('shield/users/{user}', 'UsersController@shieldUser');
	// //用户报名列表
	// Route::get('users/{user}/applycations', 'UsersController@userApplycations');
	// //新增用户
	// Route::get('new/user/num', 'UsersController@newUserNum');

	/**
	 * 管理员
	 */
	//管理员列表
	Route::get('admins', 'UsersController@adminUsers');
	//修改管理员
	Route::put('users/{user}/admin', 'UsersController@updateAdmin');
	//添加管理员
	Route::post('admins', 'UsersController@storeAdmin');
	//删除管理员
	Route::delete('users/{user}/admin', 'UsersController@deleteAdmin');

	/**
	 * 实例
	 */
	//列表
	Route::get('exmps', 'DetectionsController@examples');
	//详情
	Route::get('exmps/{example}', 'DetectionsController@example');
	//添加
	Route::post('exmp', 'DetectionsController@storeExample');
	//修改
	Route::put('exmps/{example}', 'DetectionsController@updateExample');
	//删除
	Route::delete('exmps/{example}', 'DetectionsController@deleteExample');

	/**
	 * 图片
	 */
	//图片列表
	Route::get('show/pics', 'PicsController@showPics');
	//图片修改
	Route::post('show/pics', 'PicsController@updateShowPic');
	//图片删除
	Route::delete('show/pics/{pic}', 'PicsController@deleteShowPic');
});
