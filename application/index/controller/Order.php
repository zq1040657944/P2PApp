<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
class Order extends Controller
{
    public $callback;
    public $status = 0;  // 订单的支付状态

    /** 
     * 获取返回订单的数据接口  页面默认的信息
     */
    public function getOrderInfo(){
        //接值
        $oid = Request::instance()->param('oid');
        $uid = Request::instance()->param('uid');

        //使用Query对象查询
        $list = new \think\db\Query;
        $query = $list ->name('order')
            ->where('oid',$oid)
            ->where('uid',$uid)
            ->where('status',$this->status);
        $arr = \think\Db::find($query);

        //返回的数据  用jsonp回调函数拼上自己的json数据
        return Request::instance()->param('pay')."(".json_encode($arr).")";
    }       

    //订单编号
    public function Ordernumber()
    {
        $str= date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        return $str;
    }
    /*
     * 生成订单数据
    * 参数 callback、用户id、产品id、投资金额、订单时间、订单编号
    */
    public function OrderInfo(){
        //jsonp的参数
       $this->callback=Request::instance()->param('callback');
       //用户的id
       $data['uid']=Request::instance()->param('uid');
       //产品的id
       $data['sid']=Request::instance()->param('sid');
       //投资的金额
       $data['money']=Request::instance()->param('num');
        //订单时间
       $data['creattime']=date('Y-m-d H:i:s');
       //订单编号
       $data['ordernumber']=$this->Ordernumber();
       if(empty($this->callback) ||empty($data['uid']) || empty($data['sid']) || empty($data['money'] || empty($data['creattime'] || empty($data['ordernumber']))))
       {
           $datainfo=[
               'code'=>3005,
               'msg'=>'参数有误',
           ];
           return $this->callback ."(".json_encode($datainfo).")";
       }
      $order=new \app\index\model\Order();
      $adds=$order->OrderAdd($data);
      $oid=$order->getLastInsID();
      $data=$order->GetOne($oid);
      if($adds){
          $datainfo=[
              'code'=>200,
              'msg'=>'成功',
              'data'=>$data,
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

    /*
     * 订单状态修改
     *
     */
    public function OrderState(){
        $this->callback=Request::instance()->param('callback');
        $oid=Request::instance()->param('oid');
        $pt=Request::instance()->param('pt');
        $uid=Request::instance()->param('uid');
        if(empty($oid)){
            $datainfo=[
                'code'=>3005,
                'msg'=>'参数错误',
            ];
            return $this->callback ."(".json_encode($datainfo).")";
        }
        $order=new \app\index\model\Order();
        $datainfo=$order->UpOrderStatus($uid,$oid,$pt);
        return $this->callback ."(".json_encode($datainfo).")";
    }
    /*
     *  用户的收益
     *  参数 ：uid 用户id
     */
}