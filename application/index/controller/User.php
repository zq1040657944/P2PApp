<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class User extends Controller{
    public $callback;
    public function login(){
        $request=Request::instance();
        $this->callback=$request->param('callback');
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
    public function userReg(){
        $request=Request::instance();
        $this->callback=$request->param("callback");
        $tel=$request->param("tel");
        $password=$request->param('password');
        //验证码
        $authCode=$request->param("authCode");
        //手机验证码
        $telauthcode=$request->param("telauthcode");
        $userModel=new \app\index\model\User();
        $return=$userModel->modelReg($tel,$password,$authCode,$telauthcode);
        return $request->param("callback")."(".json_encode($return).")";
    }
}