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
        $detections = $detection->with('example')->where('user_id', $user_id)->where('type', $type)->paginate();
        return $this->success('ok', $detections);
    }

}
