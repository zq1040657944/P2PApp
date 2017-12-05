<?php
namespace app\index\model;

use think\Model;
use think\Db;

class Shop extends Model
{

    //查询产品数据（查询的ID）
    public function GetOne($id){
        return $this->find($id)->toArray();
    }

}