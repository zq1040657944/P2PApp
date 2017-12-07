<?php

namespace app\index\controller;


use think\Controller;
use think\Request;

class Userinfo extends Controller
{
    public $callback;
    public $request;
    public function __construct()
    {
        $this->request=Request::instance();
    }

    /**
     * 获取用户所有信息的接口
     * 用户进入用户信息页面查找用户信息
     */
    public function gainUser(){
        $userid=$this->request->param("userid");
        $infoModel=new \app\index\model\Userinfo();
        $userinfo=$infoModel->getInfo($userid);
        return $this->request->param("callback")."(".json_encode($userinfo).")";
    }
    /*
     * 查看单个的用户的所有站内信信息
     */
    public function onMessage(){
        $userid=$this->request->param("userid");
        $userModel=new \app\index\model\Userinfo();
        $return=$userModel->getOmessage($userid);
        return $this->request->param("callback")."(".json_encode($return).")";
    }

    /**
     * 查看用户站内信息具体的
     */
    public function messageInfo(){
        $mid=$this->request->param("id");
        $userModel=new \app\index\model\Userinfo();
        $data=$userModel->getMeginfo($mid);
        return $this->request->param("callback")."(".json_encode($data).")";
    }
    /**
     * 站内信息的删除
     *id 信息id
     */
    public function messageDel(){
        $id=$this->request->param("id");
        $userModel=new \app\index\model\Userinfo();
        $return=$userModel->delMessage($id);
        return $this->request->param("callback")."(".json_encode($return).")";
    }
    /**
     * 实名认证
     */
    public function reaLname(){
        $rename=$this->request->param("rename");
        $card=$this->request->param("card");
        $userid=$this->request->param("userid");
        $userModel=new \app\index\model\Userinfo();
        $retuen=$userModel->checkName($userid,$rename,$card);
        return $this->request->param("callback")."(".json_encode($retuen).")";
    }
}