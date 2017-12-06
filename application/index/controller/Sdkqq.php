<?php
namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Request;

class Sdkqq extends Controller {
    public $callback;
    private $app_id = '101427860';
    private $app_secret = '4f1677ea81ea36ea213c13a7b58db0db';
    private $redirect = 'http://www.mywebsitezhang.xin/qq';
    public function __construct()
    {
    }
    /**
     * [get_open_id 获取用户唯一ID，openid]
     * @param [string] $token [授权码]
     * @return [array] [成功返回client_id 和 openid ;失败返回error 和 error_msg]
     */
    public function getOpenid($token){
        $str = $this->curlGetcontent('https://graph.qq.com/oauth2.0/me?access_token=' . $token);
        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos - 1);
        }
        $user = json_decode($str, TRUE);
        return $user;
    }
    /**
     * [get_access_token 获取access_token]
     * @param [string] $code [登陆后返回的$_GET['code']]
     * @return [array] [expires_in 为有效时间 , access_token 为授权码 ; 失败返回 error , error_description ]
     */
    public function getAccesstoken($code){
        $token_url = 'https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&'
            . 'client_id=' . $this->app_id . '&redirect_uri=' . urlencode($this->redirect) . '&client_secret=' . $this->app_secret . '&code=' . $code;
        $token = array();
        parse_str($this->curlGetcontent($token_url), $token);
        return $token;
    }
    /**
     * [get_user_info 获取用户信息]
     * @param [string] $token [授权码]
     * @param [string] $open_id [用户唯一ID]
     * @return [array] [ret：返回码，为0时成功。msg为错误信息,正确返回时为空。...params]
     */
    public function getUserinfo($token, $open_id){
        $user_info_url = 'https://graph.qq.com/user/get_user_info?' . 'access_token=' . $token . '&oauth_consumer_key=' . $this->app_id . '&openid=' . $open_id . '&format=json';
        $info = json_decode($this->curlGetcontent($user_info_url), TRUE);
        return $info;
    }
    private function curlGetcontent($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置超时时间为3s
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 生成qq第三方登录UEL
     */
    public function createUrl(){
        $request=Request::instance();
        $url = "http://www.mywebsitezhang.xin/index.php/index/sdkqq/callbase";
        $url = urlencode($url);
        $id = "101427860";
        $urlInterFace = "https://graph.qq.com/oauth2.0/authorize";//接口
        $arr = array(
            'response_type=code',
            "client_id={$id}",
            "redirect_uri=$url",
            "state=1",
        );
        $str = implode("&",$arr);
        $baseUrl = $urlInterFace."?".$str;
        $url=['url'=>$baseUrl];
        return $request->param('callback')."(".json_encode($url).")";
    }
    public function callBase(){
        $request=Request::instance();
        $code=$request->get("code");
        $token=$this->getAccesstoken($code);
        $strAccossToken=$token['access_token'];
        $openid=$this->getOpenid($strAccossToken);
        $app_id = $openid['openid'];
        //获取到openid
        $userModel=new User();
        $type=1;
        $return=$userModel->sdkCheck($app_id,$type);
        if($return['userid']==""){
            header("location:http://www.mywebsitezhang.xin/快易赚/binduser.html?__hbt=1512459177542&openid=$app_id&type=1");
        }else{
            $userid=$return['userid'];
            header("location:http://http://www.mywebsitezhang.xin/快易赚/index.html?__hbt=1512456318047&userid=$userid&type=1");
        }

    }
}