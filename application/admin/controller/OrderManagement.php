<?php 
namespace app\admin\controller;
header("content-type:text/html;charset=utf-8");
use think\Controller;



class Ordermanagement extends Controller
{
    public function index()
    {
    	return $this->fetch('index');
    }


    public function orderlist()
    {
    	return $this->fetch('orderlist');
    }
}


?>
