<?php   
namespace app\admin\model;  

use think\Model;  
use think\Db;  

class Slideshowm extends Model{
    //查询全部
    public function actionShow(){
    	$res = Db::name('slideshow')->select();
    	return $res;
    }
    //删除数据
    public function actionKill($id){
    	$res = Db::name('slideshow')->where('id', $id)->delete();
    	return $res;
    }
    //修改数据
    public function actionSet($status, $id){
    	$res = Db::name('slideshow')->where('id', $id)->update(['status' => $status]);
    	return $res;
    }
}  
?>  