<?php
namespace app\admin\Controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Db;
/**
*快易贷后台登录
*/

class Login extends Controller
{
	//登陆界面
	public function index(){
		return $this->fetch('login');
	}
	//login验证
	public function login(){
		$post = Request::instance();
		$data = $post->post();
		// echo "<pre>";
		// print_r($data);exit;
		$arr = $this->decodePwd($data);
		
		// $checkRes = $data['result'];
		$name = $arr['name'];
		$pwd = $arr['pwd'];

		$result = Db::name('adminuser')
        ->where("aname = '$name' AND apwd = '$pwd'")
        ->find();
        if($result){
        	$this->login_Ok($result);
            $reg = [
            	'code'=>'200',
            ];
        }else{
        	$reg = [
            	'code'=>'0001',
            	'msg'=>'账号或密码有误！'
            ];
        }
		echo json_encode($reg);
	}

	//登陆成功
	public function login_Ok($result){
		$joinname = base64_encode($result['aname']);
    	$joind = base64_encode($result['id']);

    	//七天免登陆
		// if($check){
		// 	$lifetime = 7 *24 *3600;
		// 	session_set_cookie_params($lifetime);
		// }
		Session::set('joinname', $joinname);
		Session::set('joind', $joinname);
		
	}

	//登录对称解密
	public function decodePwd($data){
		$arr['name'] = substr(base64_decode($data['pointnm']),2);
		$pwd = substr(base64_decode($data['pointpd']),0,-2);
		$arr['pwd'] = md5(base64_encode($pwd));
		
		return $arr;
	}
}