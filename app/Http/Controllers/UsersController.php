<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Str;
use App\Models\ApplicationForm;
use App\Models\Wechat;
use App\Models\JobCategory;
use App\Models\User;
use App\Models\DetectionHistory;
class UsersController extends Controller
{
	/**
	 * 我的简历
	 * @return [type] [description]
	 */
    public function user(JobCategory $category)
    {
    	$user = auth()->user();
    	return $this->success('ok', $user);
    }

    public function userDelectionHistories(Request $request, DetectionHistory $detection)
    {
        $user_id = auth()->id();
        $type = $request->input('type');
        $detections = $detection->where('user_id', $user_id)->where('type', $type)->paginate();
        return $this->success('ok', $detections);
    }

    // /**
    //  * 更新微信信息
    //  * @param  Request $request [description]
    //  * @return [type]           [description]
    //  */
    // public function updateWechat(Request $request)
    // {
    //     $user = auth()->user();
    //     $user_info = $request->input('user_info');
    //     if (count($user_info)) {
    //         if (isset($user_info['nickName'])) {
    //             $user->name = $user_info['nickName'];
    //             $user->save();
    //             $user->wechat->nickname = $user->name;
    //         }
    //         if (isset($user_info['avatarUrl'])) {
    //             $user->wechat->avatar = $user_info['avatarUrl'];
    //         }
    //         $user->wechat->save();
    //     }
    //     return $this->success('ok');
    // }

    // /**
    //  * 修改简历
    //  * @return [type] [description]
    //  */
    // public function updateUser(Request $request)
    // {	
    // 	$user = auth()->user();
    // 	if ($request->has('name') && strlen($request->name) >20 ) {
    // 		return $this->failure('请输入十个字以内的名字');
    // 	}
    // 	if ($request->name != $user->name) {
    // 		$user->name = $request->name;
    // 	}
    // 	// if ($request->has('mobile') && !Str::isMobile($request->mobile)) {
    // 	// 	return $this->failure('请输入正确的手机号');
    // 	// }
    // 	// if ($request->mobile != $user->mobile) {
    // 	// 	$user->mobile = $request->mobile;
    // 	// }
    // 	if ($request->has("sex") && $request->sex != $user->sex) {
    // 		$user->sex = $request->sex;
    // 	}
    // 	if ($request->has("birthday") && $request->birthday != $user->birthday) {
    // 		$user->birthday = $request->birthday;
    // 	}
    // 	if ($request->has("ducation") && $request->ducation != $user->ducation) {
    // 		$user->ducation = $request->ducation;
    // 	}
    // 	if ($request->has('school') && strlen($request->school) > 20 ) {
    // 		return $this->failure('请输入二十个字以内的学校名字');
    // 	}
    // 	if ($request->school != $user->school) {
    // 		$user->school = $request->school;
    // 	}
    // 	if ($request->has("province") && $request->province != $user->province) {
    // 		$user->province = $request->province;
    // 	}
    // 	if ($request->has("city") && $request->city != $user->city) {
    // 		$user->city = $request->city;
    // 	}
    // 	if ($request->has("dist") && $request->dist != $user->dist) {
    // 		$user->dist = $request->dist;
    // 	}
    //     if ($request->has("address") && $request->address != $user->address) {
    //         $user->address = $request->address;
    //     }
    // 	if ($request->has("category_id") && $request->category_id != $user->category_id) {
    // 		$user->category_id = $request->category_id;
    // 	}
    // 	if ($request->has("pay_type") && $request->pay_type != $user->pay_type) {
    // 		$user->pay_type = $request->pay_type;
    // 	}
    //     if ($user->name && $user->mobile && $user->sex && $user->birthday && $user->ducation && $user->school && $user->dist && $user->category_id && $user->pay_type) {
    //         $user->is_completed = 1;
    //     }
    // 	$user->save();
    // 	return $this->success('ok');
    // }

    // /**
    //  * 我的报名
    //  * @param  Request         $request [description]
    //  * @param  ApplicationForm $form    [description]
    //  * @return [type]                   [description]
    //  */
    // public function myApplicationForms(Request $request)
    // {
    //     $user = auth()->user();
    //     $status = $request->input('status');
    //     $forms = $user->forms()->with('job')->whereHas('job', function($sql) use($status){
    //         $sql->where('status', $status);
    //     })->orderBy('id', 'desc')->paginate();
    //     return $this->success('ok', $forms);
    // }

    // /**
    //  * 我的收藏
    //  * @param  Request $request [description]
    //  * @return [type]           [description]
    //  */
    // public function myCollectJobs(Request $request)
    // {
    //     $user = auth()->user();
    //     $collects = $user->collects()->with('job')->orderBy('id', 'desc')->paginate();
    //     return $this->success('ok', $collects);
    // }

    // public function updateUserAvatar(Request $request)
    // {
    //     $user = auth()->user();
    //     $avatar = $request->input('avatar');
    //     if (empty($avatar)) {
    //         return $this->failure('请上传头像');
    //     }
    //     $user->avatar = $avatar;
    //     $user->save();
    //     return $this->success('ok', $user);
    // }
}
