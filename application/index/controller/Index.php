<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
/**
*快易贷平台开发
*公共模块
 */

class Index extends Controller
{
    public function slideshow()
    {
    	$request = Request::instance();
        $res = Db::name('slideshow')
        ->where('status','1')
        ->order('createtime','desc')
        ->limit(4)
        ->select();
    	return $request->param("callback")."(".json_encode($res).")";
    }
}
?>
