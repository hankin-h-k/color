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

Route::post('wechat/login', 'Auth\LoginController@loginWechat');
Route::post('wechat/register', 'Auth\LoginController@wechatRegister'); 
Route::post('wechat/mobile', 'Auth\LoginController@getPhone');

Route::post('login', 'Auth\LoginController@login');
//手机号登录
Route::post('login/mobile', 'Auth\LoginController@loginMobile');

//获取上传签名
Route::get('upload/signature', 'Controller@aliyunSignature');
//短信验证码
Route::post('send/code', 'HomeController@sendCode');
Route::middleware(['auth:api'])->group(function () {
	//登出
	Route::post('logout','Auth\LoginController@logout');
	//重置密码
    Route::post('admin/reset/password', 'Auth\ResetPasswordController@resetPassword');
	/**
	 * 工作
	 */
	//工作列表
	// Route::get('jobs', 'JobsController@jobs');
	// //工作详情
	// Route::get('jobs/{job}', 'JobsController@job');
	// //工作报名
	// Route::post('join/jobs/{job}', 'JobsController@joinJob');
	// //取消报名
	// Route::post('cancel/join/jobs/{job}', 'JobsController@cancelJoinJob');
	// //收餐工作
	// Route::post('collect/jobs/{job}', 'JobsController@collectJob');
	// //工作类型
	// Route::get('job/categories', 'JobsController@jobCategories');

	// /**
	//  * 我的
	//  */
	// //我的简历
	// Route::get('user', 'UsersController@user');
	// //修改简历
	// Route::put('user', 'UsersController@updateUser');
	// //修改头像
	// Route::put('user/avatar', 'UsersController@updateUserAvatar');
	// //修改微信信息
	// Route::put('wechat', 'UsersController@updateWechat');
	// //我的报名
	// Route::get('my/application/forms', 'UsersController@myApplicationForms');
	// //我的收藏
	// Route::get('my/collect/jobs', 'UsersController@myCollectJobs');

	// /**
	//  * 首页
	//  */
	// Route::get('home', 'HomeController@home');

	// /**
	//  * 地区
	//  */
	// Route::get('addresses', 'HomeController@addresses');

	// /**
	//  * 文章
	//  */
	// Route::get('articles', 'HomeController@articles');
	// Route::get('articles/{article}', 'HomeController@article');

	//图片上传
	Route::post('uploads', 'Controller@upload');

	//首页
	Route::get('home', 'HomeController@home');
	//轮播图
	Route::get('detection/carousels', 'DetectionsController@carousels');
	//检测
	Route::post('detect', 'DetectionsController@detect');
	//检测详情
	Route::get('detection/histories/{history}', 'DetectionsController@detection');
	//我的
	Route::get('user', 'UsersController@user');
	//我的检测列表
	Route::get('user/detections', 'UsersController@userDelectionHistories');

});

