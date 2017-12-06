<?php
namespace app\admin\Controller;

use think\Controller;
use think\Session;


class Index extends Controller
{
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
}
?>