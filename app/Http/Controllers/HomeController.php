<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShowPic;
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

}
