<?php
namespace app\index\controller;
/**
 * Created by PhpStorm.
 * User: zq
 * Date: 2017/12/4
 * Time: 7:26
 */

use think\Controller;
use think\Request;
use app\index\model\Toloanrule;

class Toloan extends Controller
{
    /**
    *查询借贷月份及利率数据接口
     * @auth zq
     * @return json
     */
    public function getToloanRule()
    {
        $request = Request::instance();
        $rule = new Toloanrule();
        $ruleInfo  = $rule->SelectAll();
        return $request->param("callback")."(".json_encode($ruleInfo).")";
    }
    /**
    *等额本息计算接口
     * @param month,money
     * @return stillInterest,Interest
    */
    public function getAverageCapitalMethod()
    {
        $rule = new Toloanrule();
        $request = Request::instance();
        //接收月份
        $month = $request->param("month");
        //接收要借的钱
        $money = $request->param("money");
        $interestInfo = $rule->Interest($month,$money);
        return $request->param("callback")."(".json_encode($interestInfo).")";
    }
    /**
     * 将借款信息入库接口
     * @auth zq
     * @param Array
     * @return json
    */
    public function setToloanInfo()
    {
        $request = Request::instance();
        $getInfo = $request->param();
        $data = json_decode($getInfo,true);
        $rule = new Toloanrule();
        $info = $rule->setToloanInfo($getInfo);
        return $request->param("callback")."(".json_encode($info).")";
    }
    /**
     * 借款的详细信息接
     * @author zq <[1040657944@qq.com]>
     * @return [json] [LoanInfo]
     */
    public function getLoanInfo()
    {
        

    }
    

}

