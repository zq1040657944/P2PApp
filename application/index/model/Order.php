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

}