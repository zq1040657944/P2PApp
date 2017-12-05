<?php   
namespace app\admin\model;  

use think\Model;  
use think\Db;  

class Shopm extends Model{
    //查询全部
    public function actionShow(){
    	$res = Db::name('shop')->select();
    	return $res;
    }
    //删除数据
    public function actionKill($id){
    	$res = Db::name('shop')->where('sid', $id)->delete();
    	return $res;
    }
    //修改数据
    public function actionSet($status, $id){
    	$res = Db::name('shop')->where('sid', $id)->update(['status' => $status]);
    	return $res;
    }
    //数据入库
    public function actionAdd($data){
        $res = Db::name('shop')->insert($data);
        return $res;
    }
}  
?>  