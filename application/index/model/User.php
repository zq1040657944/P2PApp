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
     * 1006 数据库操作失败
     * 1007 手机号码不存在
     * 200 成功返回 {userid}返回用户信息
     * 100 成功返回 {userid}返回用户信息
     * 104 参数错误
     * 1005 用户不存在
     * 1008 密码不正确
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
                $time=date("Y-m-d H:i:s",time());
                $data=['lasttime'=>$time];
                Db::table("p_user")->where("tel",$username)->update($data);
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
<<<<<<< HEAD
            //为空返回 手机号不存在
            return true;
        }else{
            //手机号存在
=======
            //为空返回
            return true;
        }else{
>>>>>>> 6b57e8ffdeab1af1d48db40790f776029d203c71
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
            $data_type=['uid'=>$lastUserid];
            Db::table("p_userinfo")->insert($data_type);
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
    /**
     * 判断此用户有没有绑定第三方登录或注册
     * 如果绑定 就跳到首页
     * 没有绑定 就去绑定
     * 如果没有注册就去注册
     */
    public function sdkCheck($openid,$type){
        $userSdk=Db::table("p_user")->where("openid",$openid)->find();
        if(empty($userSdk)){
            //用户没有绑定或者还没有注册
            //把用户的openid返回前台 和登录类型
            return ['userid'=>""];

        }else{
            //用户已经绑定跳到首页把userid传到首页记住id
            return ['userid'=>$userSdk['id']];

        }
    }

    /***
     * @param $tel
     * @param $password
     * @param $openid
     * @param $type
     * 第三方登陆绑定用户
     */
    public function bindModel($tel,$password,$openid,$type){
        //判断密码是否是否为空如果为空就是绑定 不为空就是注册（相当于注册）
        $time=date("Y-m-d H:i:s",time());
        if(!empty($password)){
            //相当于注册
            $data=['tel'=>$tel,'password'=>md5($password),'opentype'=>$type,'openid'=>$openid,'creattime'=>$time,'lasttime'=>$time];
            $res=Db::table("p_user")->insert($data);
            $lastUserid=Db::table("p_user")->getLastInsID();
        }else{
            //绑定
            $data=['openid'=>$openid,"opentype"=>$type,'lasttime'=>$time];
            $res=Db::table("p_user")->where("tel",$tel)->update($data);
            $lastUserid="数据库操作失败";
        }
        if($res){
            $code="200";
            $msg=$lastUserid;
        }else{
            $code="1006";
            $msg="数据库操作失败";
        }
        return ['code'=>$code,'msg'=>$msg];
    }
    //获取用户信息
    public function getUserInfo($id)
    {
        if($id == ""){
            $success = array(
                'code' => "1004",
                "msg"  => "参数错误"
            );
        return $success;
        }
        //查询用户的详细信息
        $userInfo = Db::name('userinfo')->where('uid',$id)->find();
        //查询信息
        $user = Db::name('user')->where('id',$id)->find();
        if(empty($userInfo)){
           $success = array(
               'code' => "1005",
               'msg'  => "没有查询到用户",
           );
        return $success;
       }
        $success =array(
            'code' => '100',
            'msg'  => 'OK',
            'tel' => $user['tel'],
            'idcard' => $userInfo['idcard'],
            'realname' => $userInfo['realname']
        );
        return $success;
    }

    /**
     * @param $userid
     * 验证是否实名
     */
    public function modelAutonym($userid){
        $res=Db::table("p_user")->where("id",$userid)->find();
        return ['code'=>$res['status']];
    }

    /**
     * @param $userid
     * 判断用户登录状态
     */
    public function modelLine($userid){
        $res=Db::table("p_user")->where("id",$userid)->find();
        return ['code'=>$res['linestatus']];
    }
    public function modelOld($userid,$oldpwd,$newpwd){
        $res=Db::table("p_user")->where("id",$userid)->where("password",md5($oldpwd))->find();
        if(empty($res)){
            //密码不正确
            $code="1008";
            $msg="原密码密码不正确";
        }else{
            $data=['password'=>md5($newpwd)];
            $str=Db::table("p_user")->where("id",$userid)->update($data);
            if($str){
                $code="200";
                $msg="修改成功";
            }else{
                $code="1006";
                $msg="修改失败";
            }
        }
        return ['code'=>$code,'msg'=>$msg];
    }
<<<<<<< HEAD
    /**
     * 修改密码
     */
    public function forgetSavepwd($pwd,$tel){
        $data=['password'=>md5($pwd)];
        $str=Db::table("p_user")->where("tel",$tel)->update($data);
        if($str){
            $code="200";
            $msg="修改成功";
        }else{
            $code="1006";
            $msg="修改失败";
        }
        return ['code'=>$code,'msg'=>$msg];
    }
=======

>>>>>>> 6b57e8ffdeab1af1d48db40790f776029d203c71
    /**
     * 修改手机号
     */
    public function modelUpdatetel($userid,$authode,$tel){
        $sauthod=Session::get("note");
        if($authode!=$sauthod){
            return ['code'=>1001,$msg="验证码不正确"];
        }
        $telCheck=Db::table("p_user")->where("tel",$tel)->find();
        if(!empty($telCheck)){
            return ['code'=>1004,"msg"=>"电话号码已经存在"];
        }
        $data=['tel'=>$tel];
        $res=Db::table("p_user")->where("id",$userid)->update($data);
<<<<<<< HEAD

=======
>>>>>>> 6b57e8ffdeab1af1d48db40790f776029d203c71
        if($res){
            $code="200";
            $msg="修改成功";
        }else{
            $code="1006";
            $msg="修改失败";
        }
        return ['code'=>$code,'msg'=>$msg];

    }
}