<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShowPic;
use App\Models\Message;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request, ShowPic $pic)
    {
        //首页轮播
        $home_carousels = $pic->where('type', 'home_carousel')->orderBy('id', 'desc')->get();
        //首页展示
        $home_shows = $pic->where('type', 'home_show')->get();
        return $this->success('ok', compact('home_carousels', 'home_shows')); 
    }

    public function sendCode(Request $request, Message $message)
    {
        $mobile = $request->input('mobile');
        if (empty($mobile)) {
            return $this->failure('请输入手机号');
        }
        if(!Str::isMobile($mobile)){
            return $this->failure('手机号无效');
        }
        $num = 6;
        $code = $this->getCode($num);
        $content = '【贝素佳儿】注册验证码：'.$code.'，请勿向任何人泄露，以免造成帐号损失。';
        //创建记录  
        $this->sms->create([
            'phone' => $mobile,
            'message' => $content,
            'ip' => request()->ip(),
            'code' => $code,
            'confirmed' => 0
        ]);
        //发消息
        $result = \MessageService::sendMessage($mobile, $content);
        $result = json_decode($resul,true);
        if ($result && count($result) && $result['respCode'] == 0) {
            return $this->success('ok');
        }
        // return 
    }

    public function getCode($num)
    {
        for ($i = 0; $i < $num; $i++) { 
            $code .= rand(0, 9); 
        } 
        return $code;
    }
}
