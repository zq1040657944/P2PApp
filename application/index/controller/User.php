<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
/**
*用户中心模块
 */
class User extends Controller{
    public $callback;
    /**
     * 登录
    * @auth 常晓飞
     * @return json
     */
    public function login(){
        $request=Request::instance();
        $this->callback=$request->param('callbake');
        $username=Request::instance()->param('username');
        $pwd=Request::instance()->param('password');
        $authCode=Request::instance()->param('authCode');
        session_start();
        //服务器上验证码
        $sessionCode=$_SESSION["verification"];
        $userModel=new \app\index\model\User();
        $Usercheck=$userModel->userLogin($username,$pwd,$authCode,$sessionCode);
        return $request->param("callback")."(".json_encode($Usercheck).")";
    }
    /**
    *获取用户信息接口
     * @auth 常晓飞
     * @param uid 用户的id
     * @return json
     */
    public function getUserInfo()
    {
        $request = Request::instance();
        //接收用户的id
        $id = $request->param("id");
        $userModel=new \app\index\model\User();
        $info = $userModel->getUserInfo($id);
        return $request->param("callback")."(".json_encode($info).")";
    }
}