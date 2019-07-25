<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($msg, $data=[], $cookie = null, $jsonp = false){
		$result = [
			'code'=> 0,
			'message'=> $msg,
			'data'=> $data,
		];
		if($jsonp){
		    return Response()->jsonp('callback', $result);
        }else{
            return Response()->json($result);
        }
	}

	//接口返回失败
	public function failure($msg, $data=[], $jsonp=false){
		$result = [
			'code'=> 1,
			'message'=> $msg,
			'data'=> $data,
		];
		if($jsonp){
		    return Response()->jsonp('callback', $result);
        }else{
		    return Response()->json($result);
        }
	}

    public function test(Request $request)
    {
        $c1 = "255,255,255";
        $c2 = '248,248,255';
        $result  = $this->colorCal($c1, $c2);

        $result2 = $this->colorCal('255,255,255', ' 151,255,255');
        return $result;   
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

	public function upload(Request $request)
	{
		$file = $_FILES['fileData'];
        $result = \UploadService::uploadFile($file);
        return $this->success('ok', $result);
	}

	public function aliyunSignature(Request $request)
	{
		$response = \UploadService::aliyunSignature($request);
		return $this->success('ok', $response);
	}

    /**
     * 时间段
     * @param  [type] $start_time [description]
     * @param  [type] $end_time   [description]
     * @return [type]             [description]
     */
    public function daliy($start_time ,$end_time)
    {
        $strtime1 = strtotime($start_time);
        $strtime2 = strtotime($end_time);  
           
        $day_arr[] = date('Y-m-d', $strtime1); // 当前月;  
        while( ($strtime1 = strtotime('+1 day', $strtime1)) <= $strtime2){  
            $day_arr[] = date('Y-m-d',$strtime1); // 取得递增月;   
        } 
        return $day_arr; 
    }

    public function uploadToLocal(Request $request)
    {
	    // $file = $request->file('file');
     //    dd($file);
        $file = $_FILES['fileData'];
        // dd($request->input('file'));
	    $fileName = \UploadService::uploadToLocal($file);
        if (is_array($fileName)){
            if (isset($fileName['is_valid']) && empty($fileName['is_valid'])) {
                return $this->failure('图片无效！');
            }elseif (isset($fileName['extension']) && empty($fileName['extension'])) {
                return $this->failure('图片扩展名有误！');
            }elseif (isset($fileName['size']) && empty($fileName['size'])) {
                return $this->failure('图片尺寸大于4M！');
            }elseif (isset($fileName['request']) && empty($fileName['request'])) {
                return $this->failure('图片上传有误！');
            }
        }
        $path = config('app.url').$fileName;
        return $this->success('ok', $path);
    }
}
