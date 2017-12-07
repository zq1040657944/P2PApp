<?php
namespace app\index\model;

use think\Model;
use think\Db;

/**
 * 数据库的操作
 * 错误码
 * 4000 OK
 * 4001 参数错误
 * 4002 添加失败
*/
class Toloanrule extends Model
{
     protected $field = true;
    //查询数据
    public function SelectAll()
    {
        $toloanrule = db('toloanrule')->select();
        return $toloanrule;
    }
    //计算等额本息
    //等额本息还款法的公式:每月还款额=贷款本金×[月利率×(1+月利率) ^ 还款月数]÷{[(1+月利率) ^ 还款月数]-1}
    public function Interest($month,$money)
    {
        //判断数据是否为空
        if(empty($month) || empty($money)){
            $message = array(
                'code'=>'4001',
                'message' => "缺少参数",
            );
            return $message;
        }
        //根据前台传过来的月份进行查询月份的年收益率
        $ruleInfo = Db::name('toloanrule')->where('from_month',$month)->find();
        $year_interest = $ruleInfo['from_interest'];//年收益率
        $dkm     = $month; //贷款月数，20年就是240个月
        $dkTotal = $money; //贷款总额
        $dknl    = $year_interest;  //贷款年利率
        //每月还款金额
        $month_stillMoney = $emTotal = $dkTotal*$dknl/12*pow(1+$dknl/12,$dkm)/(pow(1+$dknl/12,$dkm)-1);
        $success = array(
            'code' => "4000",
            'message' => "OK",
            'month_stillMoney'=>sprintf("%.2f", $month_stillMoney),
            'year_interest'=>$year_interest
        );
        return $success;
    }
    //将请求的借款信息入库
    public function setToloanInfo($getInfo)
    {
        $res = Db::name('borrowinfo')->strict(false)->insert($getInfo);
        if($res){
            $message = array(
                'code' => '4000',
                'message' => 'OK'
            );
            return $message;
        }else{
            $message = array(
                'code' => '4002',
                'message' => '入库失败'
            );
            return $message;
        }
    }
    //根据用户的id查询用户的借款信息
    public function getUserToloanInfo($userid)
    {
        if($userid==""){
            $message = [
                'code'=> "4001",
                'message' => "缺少参数",
            ];
            return $message;
        }
       $info = Db::name('borrowinfo')->where('uid',$userid)->limit(0,5)->select();
       if($info == ""){
            $message = [
                'code'=> "4003",
                'message' => "当前没有借款信息",
            ];
            return $message;
       }else{
            $data = array();
            foreach($info as $k=>$v){
                if($v['status'] == '0'){
                    $data[$k]['status'] = "审核中";
                }else{
                     $data[$k]['status'] = "已审核";
                }
                $data[$k]['creat_time']=$v['creat_time'];
                $data[$k]['money'] = $v['money'];
                $data[$k]['id'] = $v['id'];
            }
            $message = [
                'code'=> "4000",
                'message' => "OK",
                'data' => $data
            ];
            return  $message;
       }
    }
    /**
     * 查询分页信息
     * @param userid,page
     * @return json
     */
    public function getPageInfo($userid,$page)
    {
        if($userid == ""){
             $message = [
                'code'=> "4001",
                'message' => "缺少参数",
            ];
            return $message;
        }
        $limit=5;
        $pre = ($page-1)*$limit;
        $userid = $userid;
        $info = Db::name('borrowinfo')->where('uid',$userid)->limit($pre,$limit)->select();
        $countinfo = Db::name('borrowinfo')->where('uid',$userid)->select();
        $count = count($countinfo);
        $sumPage = ceil($count/$limit);
        if($page>$sumPage){
                $message = [
                'code'=> "4005",
                'message' => "没有更多信息",
            ];
            return $message;
        }
        if($info == ""){
           $message = [
                'code'=> "4004",
                'message' => "当前没有借款信息",
            ];
            return $message;
        }else{
             $data = array();
            foreach($info as $k=>$v){
                if($v['status'] == '0'){
                    $data[$k]['status'] = "审核中";
                }else{
                     $data[$k]['status'] = "已审核";
                }
                $data[$k]['creat_time']=$v['creat_time'];
                $data[$k]['money'] = $v['money'];
                $data[$k]['id'] = $v['id'];
            }
            $message = [
                'code'=> "4000",
                'message' => "OK",
                'data' => $data,
                'page' => $page
            ];
            return  $message;
        }

    }   

}