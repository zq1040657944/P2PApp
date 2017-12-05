<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
class Order extends Controller
{
    public $callback;
    //订单编号
    public function Ordernumber()
    {
        $str= date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        return $str;
    }

    //生成订单数据
    public function OrderInfo(){
        //jsonp的参数
        $this->callback=Request::instance()->param('callback');
        //用户的id
        $data['uid']=Request::instance()->param('uid');
        //产品的id
        $data['sid']=Request::instance()->param('sid');
        //投资的金额
        $data['money']=Request::instance()->param('num');
        $data['creattime']=time(); //订单时间
        $data['ordernumber']=$this->Ordernumber();

        $order=new \app\index\model\Order();
        $adds=$order->OrderAdd($data);
        if($adds){
            $datainfo=[
                'code'=>200,
                'msg'=>'成功',
            ];
        }else{
            $datainfo=[
                'code'=>3001,
                'msg'=>'订单创建失败',
            ];
        }
        return $this->callback."(".json_encode($datainfo).")";
    }

    /*
     * 产品的详细数据
     * 产品的id
     */

    public function Shopinfo(){
        $this->callback=Request::instance()->param('callback');
        //产品的id是模拟的 $sid=1;
        $sid=Request::instance()->param('sid');

        if(empty($sid)){
            $datainfo=[
                'code'=>3003,
                'msg'=>'数据有误',
            ];
            return $this->callback ."(".json_encode($datainfo).")";
        }
        $shop=new \app\index\model\Shop();
        $data= $shop->GetOne($sid);
        if($data){
            $datainfo=[
                'code'=>200,
                'msg'=>'数据成功',
                'data'=>$data,
            ];
        }else{
            $datainfo=[
                'code'=>3002,
                'msg'=>'没有该数据',
            ];
        }
        return $this->callback ."(".json_encode($datainfo).")";
    }

}