<?php
namespace app\index\model;

use think\Model;
use think\Db;

/**
 * 数据库的操作
 * 错误码
 * 400 OK
 * 401 参数错误
 * 402 添加失败
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
                'code'=>'401',
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
            'code' => "400",
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
                'code' => '400',
                'message' => 'OK'
            );
            return $message;
        }else{
            $message = array(
                'code' => '402',
                'message' => '入库失败'
            );
            return $message;
        }
    }

}