<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Username;
/**
*快易贷平台开发
 */
class Index extends Controller
{
    public function index()
    {
    	return $this->fetch('index');
    }
}
