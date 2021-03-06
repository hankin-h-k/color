<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionHistory;
use App\Models\Example;
use App\Models\ShowPic;
use App\Models\ExampleColor;
use App\Models\DetectionColor;
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
    public function detect(Request $request, Example $example, DetectionHistory $detection, ExampleColor $exampleColor)
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
        // $example_id = $exampleColor->where('color_value', $color_value)->value('example_id');
        // if (empty($example_id)) {
        //     return $this->failure('没有该颜色对应的症状，请联系客服.');
        // }
    	$example_colors = $exampleColor->all();
    	// $data = [];
    	$value = 1;
        $result_value = 1;
    	foreach ($example_colors as $key => $e) {
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
    	}
        if ($value > 30) {
            //添加未识别记录
            $detection_color = DetectionColor::firstOrCreate(['color_value'=>$result_value]);
            return $this->failure('没有该颜色对应的症状，请联系客服.');
        }
    	//获取最小的
    	$example_color = $exampleColor->where('color_value', $result_value)->first();
        // dd($value);
        if (empty($example_color)) {
            return $this->failure('未能检测到图片');
        }
        $example = $example->find($example_color->example_id);
    	//添加检测记录
    	$history = $detection->create([
    		'user_id'=>auth()->id(),
    		'pic' => $pic,
    		'example_id'=>$example_color->example_id,
    		'type'=>$type,
    	]);
    	return $this->success('ok', compact('example', 'history', 'example_color'));
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
        // $r3 = $r1 - $r2;
        // $g3 = $g1 - $g2;
        // $b3 = $b1 - $b2;
        // $result = sqrt($r3 * $r3 + $g3 * $g3 + $b3 * $b3)/sqrt(255*255+255*255+255*255);
        $rmean = ($r1 + $r2) /2;
        $r3 = $r1 - $r2;
        $g3 = $g1 - $g2;
        $b3 = $b1 - $b2;
        $result = sqrt((2+$rmean/256)*($r3 * $r3)+4*($g3 * $g3)+(2+(255-$rmean)/256)*($b3 * $b3));
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

    public function examples(Request $request, Example $exap)
    {
        $exaps = $exap->orderBy('id', 'desc');
        $nopage = $request->input('nopage');
        if ($nopage) {
            $exaps = $exaps->get();
        }else{
            $exaps = $exaps->paginate();
        }
        return $this->success('ok', $exaps); 
    }

    public function userDetect(Request $request, DetectionHistory $detection)
    {
        $pic = $request->input('pic');
        $type = $request->input('type');
        // $color_value = $request->input('color_value');
        $example_id = $request->input('example_id');
        if (empty($example_id)) {
            return $this->failure('请选择实例!');
        }
        $history = $detection->create([
            'user_id'=>auth()->id(),
            'pic' => $pic,
            'example_id'=>$example_id,
            'type'=>$type,
        ]);
        $example = Example::find($example_id);
        return $this->success('ok', compact('example', 'history'));
    }
}
