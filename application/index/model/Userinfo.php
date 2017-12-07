<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Userinfo extends Model
{
    /**
     * @param $userid 用户id
     * @return 返回array
     * 查询用户所有信息
     * 1011身份证号不存在
     */
    public function getInfo($userid){
        $filed=[
            'username','tel','status','creattime','lasttime','openid','opentype','email','realname','idcard','sex','img','money'
        ];
        $site=implode(",",$filed);
        $userinfo=Db::query("select $site from p_user left JOIN p_userinfo ON p_user.id=p_userinfo.uid where uid=$userid");
        $countMessage=$this->messageGetunread($userid);
        $return=['countmessage'=>$countMessage,"userinfo"=>$userinfo];
        return $return;
    }

    /**
     * @param $userid
     * 统计未读站内信息
     */
    public function messageGetunread($userid){
        $userMessage=Db::table("p_usermessage")->where("uid",$userid)->where("status",1)->count();
        return $userMessage;
    }

    /**
     * 获取站内信息
     * @param $userid
     */
    public function getOmessage($userid){
        $data=Db::table("p_usermessage")->where("uid",$userid)->select();
        return $data;
    }
    public function getMeginfo($mid){
        $data=Db::table("p_usermessage")->where("mid",$mid)->find();
        if($data['status']==1){
            $str=['status'=>0];
            //修改未读状态
            Db::table("p_usermessage")->where("mid",$mid)->update($str);
        }

        return $data;
    }
    public function delMessage($id){
        $res=Db::table("p_usermessage")->where("mid",$id)->delete();
        if($res){
            $code="200";
            $msg="删除成功";
        }else{
            $code="1006";
            $msg="数据删除失败";
        }
        return ['code'=>$code,"msg"=>$msg];
    }

    /**
     * @param $userid
     * @param $rename
     * @param $card
     * 实名制认证
     */
    public function checkName($userid,$rename,$card){
        $res=Db::table("p_idcard")->where("idcard",$card)->find();
        if(!empty($res)){
            if($res['name']==$rename){
                $data=['realname'=>$rename,'idcard'=>$card];
                $str=Db::table("p_userinfo")->where("uid",$userid)->update($data);
                if($str){
                    $str=Db::table("p_user")->where("id",$userid)->update(['status'=>1]);
                    if($str){
                        $code="200";
                        $msg="实名认证成功";
                    }else{
                        $code="1006";
                        $msg="数据删除失败";
                    }
                }else{
                    $code="1006";
                    $msg="数据删除失败";
                }
            }else{
                $code="1012";
                $msg="用户名不正确";
            }
        }else{
            $code="1011";
            $msg="身份证号不存在";
        }
        return ['code'=>$code,'msg'=>$msg];
    }

}