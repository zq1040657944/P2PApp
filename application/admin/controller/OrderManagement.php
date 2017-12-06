<?php 
namespace app\admin\controller;

use think\Controller;
use \think\Request;
use app\admin\model\Order;//订单model
use app\admin\model\User;//会员model
use app\admin\model\Shop;//商品model

/**
 * [Ordermanagement 后台订单管理]
 * @author  YaPeng
 */
class Ordermanagement extends Controller
{
	

    /**
     * [orderlist 订单列表]
     * @author  YaPeng
     */
    public function orderlist()
    {
        $stu = Request::instance()->param('stu','a');

        if($stu=="a"){
            $data = Order::limit(3)->where('status = 1')->select();
        }else if($stu=="n"){
            $data = Order::limit(3)->where('status = 0')->select();
        }else{
            $this->error('参数有误');;
        }
    	
        $datah = $this->dataHandle($data);
        foreach ($datah as $key => $val) {
            $userInfo = User::find($val['uid'])->toArray();
            $shopInfo = Shop::find($val['sid'])->toArray();
            $datah[$key]['username'] = $userInfo['username'];
            $datah[$key]['sname'] = $shopInfo['sname'];
        }

        $this->assign('orderdata',$datah);

        if($stu=="a"){
            return $this->fetch('orderlist');
        }

    	return $this->fetch('orderlisttwo');
    }


    /**
     * [dataHandle 处理查询结果集]
     * @author  YaPeng
     * @param  [array] $data [待处理结果集]
     * @return [array] $arr  [处理好的结果集]
     */
    public function dataHandle($data)
    {
        $arr = [];
       foreach ($data as $key => $value) {
            $arr[] = $value->toArray();
       }

       return $arr;
    }
}


?>
