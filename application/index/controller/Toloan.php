<?php
namespace app\index\controller;
/**
 * 借贷模块的接口
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
        $rule = new Toloanrule();
        //将借款信息入库借款表
        $info = $rule->setToloanInfo($getInfo);
        return $request->param("callback")."(".json_encode($info).")";
    }
    /**
     * 借贷记录的接口
     * @return json
     */
    public function GetToloanRecord()
    {
        $request = Request::instance();
        $userid = $request->param("userid");
        //调用查询借贷记录的接口
        $rule = new Toloanrule();
        $GetToloanInfo = $rule ->getUserToloanInfo($userid);
        return $request->param("callback")."(".json_encode($GetToloanInfo).")";
    }
    /**
     * 获取点击更多信息的接口
     * @param userid,page
     * @return json
     */
    public function GetPageInfo()
    {
        $request = Request::instance();
        $userid = $request->param("userid");
        $page = $request->param("p");
        $rule = new Toloanrule();
        $pageInfo = $rule->getPageInfo($userid,$page);
        return $request->param("callback")."(".json_encode($pageInfo).")";
    }
}

