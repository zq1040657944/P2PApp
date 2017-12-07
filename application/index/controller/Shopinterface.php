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
		$id = $request->post('id');
		$res = Db::name('shop')->where('sid', $id)->find();
    	return $request->param("callback")."(".json_encode($res).")";
	}

	// 商品列表
	public function shopList(){
		$request = Request::instance();
		$res = Db::name('shop')->order('onlinetime','desc')->limit(3)->select();
    	return $request->param("callback")."(".json_encode($res).")";
	}
}
?>