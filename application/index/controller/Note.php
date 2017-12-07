<?php

namespace app\index\controller;


use app\index\model\User;
use think\Controller;
use think\Request;
use think\Session;

class Note extends Controller
{
    /**
     * @var
     * 验证错误规则
     * 1001 验证码不正确
     * 1002 用户名或密码不正确
     * 200  成功返回 {userid}返回用户信息
     * 1003 验证码发送失败
     * 1004 电话号码已经存在
     */
    public $callback;
    public function updateTel(){
        $request=Request::instance();
        $round=rand(1000,9999);
        Session::set('note',$round);
        $tel=$request->param("tel");
        $return=$this->noteCheck($tel,$round);
        if($return){
            $code="200";
            $msg="发送成功";
        }else{
            $code="1003";
            $msg="发送失败";
        }
        return $request->param("callback")."(".json_encode(['code'=>$code,'msg'=>$msg]).")";
    }
    public function forGetpwd(){
        $request=Request::instance();
        $request->param("callback");
        $round=rand(1000,9999);
        Session::set('note',$round);
        $tel=$request->param("tel");
        //查找数据库检查电话号码是否存在
        $userModel=new User();
        $checkTel=$userModel->checkTel($tel);
        if(!$checkTel){
            $return=$this->noteCheck($tel,$round);
            if($return['status']=='OK'){
                $code=200;
                $msg="发送成功";
            }else{
                $code=1003;
                $msg="发送失败";
            }
        }else{
            $code=1007;
            $msg="电话号码不存在";
        }
        $siteEr=['code'=>$code,'msg'=>$msg];
        return $request->param('callback')."(".json_encode($siteEr).")";
    }
    public function noteCallback(){
        $request=Request::instance();
        $request->param("callback");
        $round=rand(1000,9999);
        Session::set('note',$round);
        $tel=$request->param("tel");
        //查找数据库检查电话号码是否存在
        $userModel=new User();
        $checkTel=$userModel->checkTel($tel);
        if($checkTel){
            $return=$this->noteCheck($tel,$round);
            if($return['status']=='OK'){
                $code=200;
                $msg="发送成功";
            }else{
                $code=1003;
                $msg="发送失败";
            }
        }else{
            $code=1004;
            $msg="电话号码已经存在";
        }
        $siteEr=['code'=>$code,'msg'=>$msg];
        return $request->param('callback')."(".json_encode($siteEr).")";
    }
    /**
     * @短信验证接口
     */
    public function noteCheck($tel,$round){
        $nowapi_parm['app']='sms.send';
        $nowapi_parm['param']="username%3D$tel%26code%3D$round";
        $nowapi_parm['tempid']='51263';
        $nowapi_parm['phone']=$tel;
        $nowapi_parm['appkey']='28808';
        $nowapi_parm['sign']='3285b827a4aa12e32a49ae9893424d8c';
        $nowapi_parm['format']='json';
        $result=$this->nowapiCall($nowapi_parm);
        return $result;
    }
    Public function nowapiCall($a_parm){
        if(!is_array($a_parm)){
            return false;
        }
        //combinations
        $a_parm['format']=empty($a_parm['format'])?'json':$a_parm['format'];
        $apiurl=empty($a_parm['apiurl'])?'http://api.k780.com/?':$a_parm['apiurl'].'/?';
        unset($a_parm['apiurl']);
        foreach($a_parm as $k=>$v){
            $apiurl.=$k.'='.$v.'&';
        }
        $apiurl=substr($apiurl,0,-1);
        if(!$callapi=file_get_contents($apiurl)){
            return false;
        }
        //format
        if($a_parm['format']=='base64'){
            $a_cdata=unserialize(base64_decode($callapi));
        }elseif($a_parm['format']=='json'){
            if(!$a_cdata=json_decode($callapi,true)){
                return false;
            }
        }else{
            return false;
        }
        //array
        if($a_cdata['success']!='1'){
            echo $a_cdata['msgid'].' '.$a_cdata['msg'];
            return false;
        }
        return $a_cdata['result'];
    }
}