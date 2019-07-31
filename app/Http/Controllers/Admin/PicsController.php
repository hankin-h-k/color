<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShowPic;
class PicsController extends Controller
{	
	/**
	 * 图片列表
	 * @param  Request $request [description]
	 * @param  ShowPic $showPic [description]
	 * @return [type]           [description]
	 */
	public function showPics(Request $request, ShowPic $showPic)
	{
		$type = $request->input('type');
		if (empty($type)) {
			return $this->failure('请选择轮播图类型');
		}
		$pics = $showPic->where('type', $type)->get();
		return $this->success('ok', $pics);
	}

	/**
	 * 图片修改
	 * @param  Request $request [description]
	 * @param  ShowPic $showPic [description]
	 * @return [type]           [description]
	 */
	public function updateShowPic(Request $request, ShowPic $showPic)
	{
		$type = $request->input('type');
		if (empty($type)) {
			return $this->failure('请选择轮播图类型');
		}
		$showPic->where('type', $type)->delete();
		$pics = $request->input('pics', []);
		if (count($pics)) {
			$showPic->create($pics);
		}
	}

	/**
	 * 图片删除
	 * @param  Request $request [description]
	 * @param  ShowPic $showPic [description]
	 * @return [type]           [description]
	 */
	public function deleteShowPic(Request $request, ShowPic $showPic)
	{
		$showPic->delete();
		return $this->success('ok');
	}
}
