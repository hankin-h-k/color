<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionHistory;
use App\Models\Example;
use App\Models\ShowPic;
class DetectionsController extends Controller
{
	/**
	 * 轮播图
	 * @param  Request $request [description]
	 * @param  ShowPic $pic     [description]
	 * @return [type]           [description]
	 */
    public function carousels(Request $request, ShowPic $pic)
    {
  		$type = $request->input('type', 'baby_carousel');
    	$carousels = $pic->where('type', $type)->orderBy('id', 'desc')->get();
    	return $this->success('ok', $carousels);
    }

    /**
     * 检测
     * @param  Request          $request   [description]
     * @param  Example          $example   [description]
     * @param  DelectionHistory $detection [description]
     * @return [type]                      [description]
     */
    public function detect(Request $request, Example $example, DetectionHistory $detection)
    {
    	$color_value = $request->input('color_value');
        if (empty($color_value)) {
            return $this->failure('请确定图片颜色');
        }
    	$type = $request->input('type');
    	$pic = $request->input('pic');
    	if (empty($pic)) {
    		return $this->failure('请上传需要检测的图片');
    	}
    	$examples = $example->all();
    	// $data = [];
    	$value = 1;
        $result_value = 1;
    	foreach ($examples as $key => $e) {
    		$result = $this->colorCal($color_value, $e->color_value);//越小颜色越接近
            \Log::info('color_value: '.$result);
            if ($key == 0) {
    		    $value = $result;
                $result_value = $e->color_value;
    		    continue;
            }
    		if ($result < $value) {
    			$value = $result;
                $result_value = $e->color_value;
    		}
            // dd($value);
    	}
    	//获取最小的
    	$example = $examples->where('color_value', $result_value)->first();
        if (empty($example)) {
            return $this->failure('未能检测到图片');
        }
    	//添加检测记录
    	$history = $detection->create([
    		'user_id'=>auth()->id(),
    		'pic' => $pic,
    		'example_id'=>$example->id,
    		'type'=>$type,
    	]);
    	return $this->success('ok', compact('example', 'history'));
    }

    public function colorCal($c1, $c2)
    {
        $c1_arr = explode(',', $c1);
        $c2_arr = explode(',', $c2);
        $r1 = $c1_arr[0];
        $r2 = $c2_arr[0];
        $g1 = $c1_arr[1];
        $g2 = $c2_arr[1];
        $b1 = $c1_arr[2];
        $b2 = $c2_arr[2];
        $r3 = ($r1 - $r2) /256;
        $g3 = ($g1 - $g2)/256;
        $b3 = ($b1 - $b2)/256;
        $result  = sqrt($r3 * $r3 + $g3 * $g3 + $b3 * $b3);
        return $result;
    }

    /**
     * 检测详情
     * @param  Request          $request   [description]
     * @param  DetectionHistory $detection [description]
     * @return [type]                      [description]
     */
    public function detection(Request $request, DetectionHistory $detection)
    {
    	return $this->success('ok', $detection);
    }
}
