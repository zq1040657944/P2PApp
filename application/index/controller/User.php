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
    public $request;
    public function __construct()
    {
        $this->request=Request::instance();
    }
    /**
     * 登录
    * @auth 常晓飞
     * @return json
     */
    public function login(){

        $this->callback=$this->request->param('callback');
        $username=Request::instance()->param('username');
        $pwd=Request::instance()->param('password');
        $authCode=Request::instance()->param('authCode');
        session_start();
        //服务器上验证码
        $sessionCode=$_SESSION["verification"];
        $userModel=new \app\index\model\User();
        $Usercheck=$userModel->userLogin($username,$pwd,$authCode,$sessionCode);
        return $this->request->param("callback")."(".json_encode($Usercheck).")";
    }
    public function userReg(){
        $this->callback=$this->request->param("callback");
        $tel=$this->request->param("tel");
        $password=$this->request->param('password');
        //验证码
        $authCode=$this->request->param("authCode");
        //手机验证码
        $telauthcode=$this->request->param("telauthcode");
        $userModel=new \app\index\model\User();
        $return=$userModel->modelReg($tel,$password,$authCode,$telauthcode);
        return $this->request->param("callback")."(".json_encode($return).")";
    }

    /***
     * 查询电话号码是否存在
     * 不存在就是没有注册
     * 存在就是已经注册了
     */
    public function selectTel(){
        $tel=$this->request->param("tel");
        $userModel=new \app\index\model\User();
        $res=$userModel->checkTel($tel);
        if($res){
           $code="1007";
            $msg="手机号已经存在";
        }else{
            $code="1004";
            $msg="手机号码不存在";
        }
        $return=['code'=>$code,"msg"=>$msg];
        return $this->request->param("callback")."(".json_encode($return).")";
    }
    /**
     * 绑定第三方登录
     */
    public function bindUser(){
        $tel=$this->request->param("tel");
        $password=$this->request->param("password");
        $openid=$this->request->param("openid");
        $type=$this->request->param("type");
        $userModel=new \app\index\model\User();
        $res=$userModel->bindModel($tel,$password,$openid,$type);
        return $this->request->param("callback")."(".json_encode($res).")";
    }
    public function userReg(){
        $request=Request::instance();
        $this->callback=$request->param("callback");
        $tel=$request->param("tel");
        $password=$request->param('password');

        //验证码
        $authCode = $request->param("authCode");
        //手机验证码

        $telauthcode = $request->param("telauthcode");
        $userModel = new \app\index\model\User();
        $return = $userModel->modelReg($tel, $password, $authCode, $telauthcode);
        return $request->param("callback") . "(" . json_encode($return) . ")";
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