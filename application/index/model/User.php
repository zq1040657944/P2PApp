<?php
namespace app\index\model;

use think\Db;
use think\Model;
use think\Session;

class User extends Model{
    /**
     * 用户登录验证
     * @param $username,$pwd,$authCode,$sessionCode
     * return array
     * 返回规则
     * 1001 验证码不正确
     * 1002 用户名或密码不正确
     * 1004 电话号码已经存在
     * 1005 手机验证码不存在
     * 1006 入库失败
     * 200 成功返回 {userid}返回用户信息
     */
    public function userLogin($username,$pwd,$authCode,$sessionCode){
        //验证验证码是否正确
        //定义返回数组
        if($authCode!=$sessionCode){
            return ['code'=>1001,'msg'=>'验证码错误'];
        }
        //查询是手机号
        $Usertel=Db::table('p_user')->where('tel',$username)->find();

        if(!empty($Usertel)){

            if($Usertel['password']==md5($pwd)){
                //用户名和密码及验证吗都正确
                $code=200;
                //把用户id传到前台去
                $msg=$Usertel['id'];
            }else{
                $code=1002;
                $msg="用户名密码不存在";
            }
        }else{
            $code=1002;
            $msg="用户名密码不存在";
        }
       return ["code"=>$code,"msg"=>$msg];
    }

    /**
     * @param $tel
     * @return bool
     * 手机验证码验证手机号是否存在
     */
    public function checkTel($tel){
        $userTel=Db::table("p_user")->where('tel',$tel)->find();
        if(empty($userTel)){
            //为空返回
            return true;
        }else{
            return false;
        }
    }
    public function modelReg($tel,$pwd,$authCode,$telauthcode){
        session_start();
        //服务器上验证码
        $sessionCode=$_SESSION["verification"];
        if($authCode!=$sessionCode){
            return ['code'=>1001,'msg'=>"验证码不正确"];
        }
        //手机验证
        $telnote=Session::get("note");
        $userTel=Db::table("p_user")->where("tel",$tel)->find();
        if(empty($userTel)){
            //手机号码不存在
            //判断手机验证码是否正确
            if($telauthcode!=$telnote){
                return ['code'=>1005,'msg'=>"手机验证码不正确"];
            }
            $data=['tel'=>$tel,'password'=>md5($pwd),'creattiome'=>date("Y-m-d H:i:s",time())];
            $res=Db::table("p_user")->insert($data);
            $lastUserid=Db::table("p_user")->getLastInsID();
            if($res){
               $code=200;
               $msg=$lastUserid;
            }else{
                $code="1006";
                $msg="入库失败";
            }
        }else{
            $code=1004;
            $msg="电话号码已经存在";
        }
        return ['code'=>$code,'msg'=>$msg];
    }
}


?>