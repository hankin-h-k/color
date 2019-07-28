<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Example;
use App\Models\DetectionHistory;
use App\Models\User;
class DetectionsContoller extends Controller
{	
	/**
	 * 实例列表
	 */
    public function examples(Request request, Example $example)	
    {
    	$examples = $example->orderBy('id', 'desc')->paginate();
    	return $this->success('ok', $examples);
    }	

    /**
     * 实例详情
     */
    public function example(Request $request, Example $example)
    {
    	return $this->success('example');
    }

    /**
     * 创建实例
     */
    public function storeExample(Request $request, Example $example)
    {
    	$data['pic'] = $request->input('pic');
    	if (empyt($data['pic'])) {
    		return $this->failure('请上传对比图');
    	}
    	$data['name'] = $request->input('name');
    	if (empty($data['name'])) {
    		return $this->failure('请输入名称');
    	}
    	$data['color_value'] = $request->input('color_value');
    	if (empty($data['color_value'])) {
    		return $this->failure('请选择检测色值');
    	}
    	$data['type'] = $request->input('type');
    	if (empty($data['type'])) {
    		return $this->failure('没有实例类型');
    	}
    	$intro = $request->input('intro');
    	$e = $example->create($data);
    	return $this->success('ok', $e);
    }

    /**
     * 修改实例
     */
    public function updateExample(Request $request, Example $example)
    {
    	if ($request->input('pic') && $request->input('pic') != $example->pic) {
    		$example->pic = $request->pic;
    	}
    	if ($request->input('name') && $request->input('name') != $example->name) {
    		$example->name = $request->name;
    	}
    	if ($request->input('color_value') && $request->input('color_value') != $example->color_value) {
    		$example->color_value = $request->color_value;
    	}
    	if ($request->input('intro') && $request->input('intro') != $example->intro) {
    		$example->intro = $request->intro;
    	}
    	$example->save();
    	return $this->success('ok', $example);
    }

    /**
     * 删除实例
     */
    public function deleteExample(Request $request, Example $example)
    {	
    	$example->delete();
    	return $this->success('ok');
    }


    /**
     * 用户的测试结果
     */
    public function userDetctions(Request $request, User $user, DetectionHistory $detection)
    {
    	$histories = $detection->with(['user', 'example'])->where('user_id', $user->id)->where('type', $type)->paginate();
    	return $this->success('ok', $histories);
    }


}



