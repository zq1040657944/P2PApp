<?php
namespace app\admin\Controller;

use think\Controller;
use think\Session;
/**
*快易贷后台轮播图
*/

class Slideshow extends Controller
{
	public function _initialize(){
		$key1 = Session::get('joinname');
		$key2 = Session::get('joind');
		if(empty($key1)||empty($key2)){
			$this->error('请先登录!','Login/index');
		}
	}

	public function Index(){
		$this->fetch('slideshowAdd');
	}
}