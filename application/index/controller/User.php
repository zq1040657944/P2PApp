<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

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
    /**
     * 判断是否实名
     */
    public function checkAutonym(){
        $userid=$this->request->param("userid");
        $userModel=new \app\index\model\User();
        $return=$userModel->modelAutonym($userid);
        return $this->request->param("callback")."(".json_encode($return).")";
    }

    /**
     * @param $userid
     * 判断用户登录状态
     */
    public function checkLine(){
        $userid=$this->request->param("userid");
        $userModel=new \app\index\model\User();
        $return=$userModel->modelLine($userid);
        return $this->request->param("callback")."(".json_encode($return).")";
    }

    /**
     * 验证原密码
     */
    public function ckeckOldpwd(){
        $userid=$this->request->param("userid");
        $oldpwd=$this->request->param("oldpwd");
        $newpwd=$this->request->param("newpwd");
        $userModel=new \app\index\model\User();
        $return=$userModel->modelOld($userid,$oldpwd,$newpwd);
        return $this->request->param("callback")."(".json_encode($return).")";
    }

    /**
     * 修改手机号
     */
    public function updateTel(){
        $userid=$this->request->param("userid");
        $authoud=$this->request->param("authoud");
        $tel=$this->request->param("newtel");
        $UserModel=new \app\index\model\User($userid,$authoud,$tel);
        $return=$UserModel->modelUpdatetel($userid,$authoud,$tel);
        return $this->request->param("callback")."(".json_encode($return).")";
    }
    /**
     * 验证手机验证码
     */
    public  function checkAuths(){
        $authod=$this->request->param("authod");
        $authodSession=Session::get("note");
        if($authod!=$authodSession){
            $code="1005";
            $msg="验证码不正确";
        }else{
            $code="200";
            $msg="验证码不正确";
        }
       $return=['code'=>$code,'msg'=>$msg];
        return $this->request->param("callback")."(".json_encode($return).")";
    }
    public function forGetsave(){
        $pwd=$this->request->param("pwd");
        $tel=$this->request->param("tel");
        $userModel=new \app\index\model\User();
        $return=$userModel->forgetSavepwd($pwd,$tel);
        return $this->request->param("callback")."(".json_encode($return).")";
    }
}