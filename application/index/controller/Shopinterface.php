<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
*产品接口
*@author  常奥康 
*@return  json
*@param 
*/

class Shopinterface extends Controller
{
    // 商品详情
	public function shopInfo(){
		$request = Request::instance();
		$id = $request->param('id');
		$res['res'] = Db::name('shop')->where('sid', $id)->find();
    	return $request->param("callback")."(".json_encode($res).")";
	}

	// 商品列表
	public function shopList(){
		$request = Request::instance();
		$num = Db::name('shop')->count();
		$res['num'] = ceil($num/3);
		$res['data'] = Db::name('shop')->order('onlinetime','desc')->limit(3)->select();
    	return $request->param("callback")."(".json_encode($res).")";
	}
	// 商品列表
	public function shopPage(){
		$request = Request::instance();
		$limit = $request->param('limit');
		$type = empty($request->param('type'))?'':$request->param('type');
		$val = empty($request->param('val'))?'':$request->param('val');
		
		if(empty($type)||empty($val)){
			$type = 'sname';
			$val = 'not null';
		}

		$num = Db::name('shop')->where($type, $val)->count();
		$res['num'] = ceil($num/3);
		$res['data'] = Db::name('shop')
		->order('onlinetime','desc')
		->where($type, $val)
		->limit($limit)
		->select();

    	return $request->param("callback")."(".json_encode($res).")";
	}
}
?>