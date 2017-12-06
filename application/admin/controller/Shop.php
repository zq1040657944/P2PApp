<?php
namespace app\admin\Controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\admin\model\Shopm;

/**
*快易贷后台产品
*/

class Shop extends Controller
{
	//登录验证
	public function _initialize(){
		$key1 = Session::get('joinname');
		$key2 = Session::get('joind');
		if(empty($key1)||empty($key2)){
			$this->error('请先登录!','Login/index');
		}
	}
	//产品添加页面
	public function index(){
		return $this->fetch('shopAdd');
	}
	//数据添加
	public function dataAdd(){
		$addData = Request::instance()->post();
		$addData['salary'] = $addData['salary']*0.01;
		$addData['onlinetime'] = $addData['onlinetime'].' 06:00:00';
		
		$shop = new Shopm();
		$result = $shop->actionAdd($addData);
		if($result){
        	$this->redirect('shop/shopList');
        }else{
        	$this->error('添加失败');
        }
	}

	//展示页面
	public function shopList(){
		$shop = new Shopm();
		$result = $shop->actionShow();
		return $this->fetch('shopList',[
			'data'=>$result
		]);
	}
	//删除数据
	public function killData(){
		$d = Request::instance()->post('d');
		$shopm = new Shopm();
		$result = $shopm->actionKill($d);
		if($result){
			$arr = [
				'code' => '200',
				'msg' => '操作成功！'
			];
		}else{
			$arr = [
				'code' => '0001',
				'msg' => '操作失败！'
			];
		}
		echo json_encode($arr);
	}
}