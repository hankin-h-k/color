<?php

namespace App\Services;

use App\Models\Message;
class MessageService

{
    /*
     * 检查是否合法
     * 1. 正常返回false
     * 2. 失败返回原因
     *
     * todo:
     * 1. 只有最近, 旧的失效
     */
    function check($mobile, $code){
        if(!$code){
            return '请填写验证码';
        }

        //测试用万能验证码
        // if(/*(config('app.testing') && $code=='999999999')*/  $code=='999999999' || $mobile=='13800138000'){
        //     Message::where('phone', $mobile)->update(['confirmed'=>1]);
        //     return false;
        // }
       	if ($code == '999999999') {
       		return false;
       	}

        $record = Message::where(['phone'=>$mobile, 'code'=>$code])/*->orderBy('id', 'desc')*/->first();

        if(empty($record)){
            return '验证码有误';
        }

        if($record->created_at->timestamp < (time()-10*60)){
            return '验证码过期';
        }

        if($record->confirmed){
            return '验证码已使用';
        }

        Message::where('id', $record->id)->update(['confirmed'=>1]);

        return false;
        
    }

    public sendMessage($mobile, $content)
    {
        $url = "http://47.107.123.77:8860/sendSms";//请求URL
        $api_code = "C00003";//对接协议中的API代码
        $api_secret = "TU1CO4J400";//对接协议中的API密码
        $sign = md5($content.$api_secret);//md加密后短信内容+API密码 获得签名
        $bodys = [
            'cust_code'=>$api_code,
            'content' => $content,
            'destMobiles' => $mobile,
            'sign' => $sign,
        ];
        $data_string = json_encode($bodys);
        if (!function_exists('curl_init'))
        {
            return '';
        }
        // $curl = curl_init();
        //设置url
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/html'));// 文本提交方式，必须声明请求头
        $data = curl_exec($ch);
        // curl_close($ch);

        if($data === false){
            var_dump(curl_error($ch));
        }else{
            curl_close($ch);
        }
        return$data;
    }
} 