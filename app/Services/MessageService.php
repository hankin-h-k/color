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
}