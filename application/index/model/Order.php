<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Order extends Model
{

    //添加数据（数据）
    public function OrderAdd($data){
       return Db::table('p_order')->insert($data);
       // return $this->insert($data);
    }

    //订单数据
    public function GetOne($oid)
    {
        return $this->find($oid)->toArray();
    }

    //订单状态修改   parameter : $oid  订单的id
    public function OrderUpd($oid)
    {
        return Db::table('p_order')->where('oid',$oid)->setField('status', '1');
        //return $this->get($oid)->update($data);
    }
    /**
     * 查询订单的信息
     */
    public function GetOrderInfo($oid,$uid){
        //使用Query对象查询
        $list = new \think\db\Query;
        $query = $list ->name('order')
            ->where('oid',$oid)
            ->where('uid',$uid)
            ->where('status',$this->status);
        $arr = \think\Db::find($query);
        
        return $arr;
    }
     /**
      * 更新订单状态
      */
    public function UpOrderStatus($uid,$oid,$pt){
        $this->status = 1;
        $res = Db::table('p_order')
              ->where('oid',$oid)
              ->update([
                'status' => $this->status,
                'payType'=> $pt,
              ]);
        return $res;
        // if($res){
        //     $datainfo=[
        //         'code'=>200,
        //         'msg'=>'数据成功',
        //       ];
        // }else{
        //     $datainfo=[
        //         'code'=>3004,
        //         'msg'=>'订单编辑失败',
        //     ];
        // }
    }

}