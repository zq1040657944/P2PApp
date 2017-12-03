<?php
namespace app\index\model;

use think\Db;
use think\Model;

class User extends Model{
    /**
     * 用户登录验证
     * @param $username,$pwd,$authCode,$sessionCode
     * return array
     * 返回规则
     * 2001 验证码不正确
     * 2002 用户名或密码不正确
     * 200 成功返回 {userid}返回用户信息
     */
    public function userLogin($username,$pwd,$authCode,$sessionCode){
        //验证验证码是否正确
        //定义返回数组
        if($authCode!=$sessionCode){
            return ['code'=>2001,'msg'=>'验证码错误'];
        }
        //查询是手机号
        $Usertel=Db::table('p_user')->where('tel',$username)->find();

        if(!empty($Usertel)){
            //用户已经注册
//            e10adc3949ba59abbe56e057f20f883e
//            e10adc3949ba59abbe56e057f20f883e
            if($Usertel['password']==md5($pwd)){
                //用户名和密码及验证吗都正确
                $code=200;
                //把用户id传到前台去
                $msg=$Usertel['id'];
            }else{
                $code=2002;
                $msg="密码错误";
            }
        }else{
            $code=2003;
            $msg="用户名不存在";
        }
       return ["code"=>$code,"msg"=>$msg];
    }
}


?>