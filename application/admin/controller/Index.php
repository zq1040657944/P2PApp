<?php
namespace app\admin\Controller;

use think\Controller;
<<<<<<< HEAD
use think\Session;
/**
*快易贷后台首页
=======

/**
*快易贷后台模块
>>>>>>> bdf33accfd1be915da63d42a9988369799a9df4f
*/

class Index extends Controller
{
<<<<<<< HEAD
	public function _initialize(){
		$key1 = Session::get('joinname');
		$key2 = Session::get('joind');
		if(empty($key1)||empty($key2)){
			$this->error('请先登录!','Login/index');
		}
	}
	public function index(){
		return $this->fetch('index');
	}

	//退出登录
	public function loginOut(){
		Session::set('joinname','');
		Session::set('joind','');
		$this->redirect('Login/index');
	}
=======
	public function index(){
		return $this->fetch('index');
	}
>>>>>>> bdf33accfd1be915da63d42a9988369799a9df4f
}
?>