<?php
namespace app\admin\Controller;

use think\Controller;

/**
*快易贷后台模块
*/

class Index extends Controller
{
	public function index(){
		return $this->fetch('index');
	}
}
?>