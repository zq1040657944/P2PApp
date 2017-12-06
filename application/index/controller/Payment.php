<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Pay;
use app\index\model\Order;
error_reporting(0);

class Payment extends Controller
{
	public $mstatus = 3;
	public $payType = 0;

		/**
		* 判断支付方式的代码
		*/
	public function Payment(){
		 //接值
		$data = Request::instance()->param();
		//进行判断  看是哪一种的支付方式
		switch($data['pt']){
			//我的余额
			case '0':
				$msg =  $this->myBlance($data['uid'],$data['money'],$data['sid'],$data['oid'],$data['pt']); 
			break;
			
			//支付宝支付
			case '1':
				$msg = $this->Alipay($data);
			break;

			//银联支付
			case '2':
				$msg = $this->MyUnionPay($data);
			break;

			//微信支付
			case '3':
				$msg = $this->WechatPay($data);	
			break;
		}
		return Request::instance()->param('pay')."(".json_encode($msg).")";
	}

		/**
		* 支付方式为 我的余额
		*/
		public function myBlance($uid,$money,$sid,$oid,$pt){
			$pay = new Pay;
			$userMoney = $pay->getMoney($uid);
			if($userMoney >= $money){
				//1.减少可投资的金额 
				$res =  $this->UpRecord(['uid'=>$uid,'mstatus'=>$this->mstatus,'money'=>$money,'sid'=>$sid]);
				if($res){
					//2.减少我的余额
					$resUser = $pay->UpUserMoney($uid,$money);				
					if($resUser){
						//修改订单状态
						$Order = new Order;
						$Order->UpOrderStatus($uid,$oid,$pt);
						if($Order){
							$msg = [
								'code' => '2000',
								'msg' => '支付成功',
								'uid' => $uid,
								'oid' => $oid,
								'pt'  => $pt
							];
							return $msg;
						}
					}else{
						$msg = [
							'code' => '2007',
							'msg'  => '支付失败！！！',
						];
						return $msg;
					}
				}else{
					$msg = [
						'code' => '2008',
						'msg'  => '扣款失败',
					];
					return $msg;
				}
			}else{
				$msg = [
					'code' => '2006',
					'msg'  => '您的余额不足，请选择另外一种支付方式 或者充值',
				];
				return $msg;
			}
		}
	 /**
	  * 减少可投资的金额
	  */
	 public function UpRecord($data){
		//实例化模型
		$pay = new Pay;
		//更新已投资的金额	  
		$res = $pay -> UpInterMoney($data);
		if($res){
		//组装要插入的数据
			$arr = [
			  'uid' => $data['uid'],
			  'mstatus' => $this->mstatus,
			  'money' => $data['money'],
			  'sid' => $data['sid'],
			];
		//插入我的投资记录中
		$RecordId = $pay -> AddRecord($arr);
		return true;
		}else{
		  return false;
		}
	}	  
	  /*
	   * 支付方式 支付宝
	   */
		public function Alipay($data){
			$pay = new Pay;  //实例化模型 方便调用
			$orderInfo = $pay ->getOrderInfo($data['oid'],$data['uid']);
			$payData = [
				'notify_url' => request()->domain().url('index/payment/alipay_notify'),
				'return_url' => request()->domain().url('index/payment/alipay_return'),
				'out_trade_no' => $orderInfo['ordernumber'],
				'subject' => '商品呢',
				'total_fee' => $data['money'],//订单金额，单位为元
				'body' => '这真是一个好东西',
			];
			
			//返回code 
			$res = $pay->alipay($payData);
			return $res;
		}

		/**
		 * 支付宝同步返回结果
		 */
		public function alipay_return(){
			$pay = new Pay;
			//$pay->return_alipay($this->mstatus);
			if($pay->return_alipay($this->mstatus)){
				$this->success('支付成功','payment/lists');
			}else{
				echo "支付失败";
			}
		}

		/**
		 * 支付宝测试action
		 */
		public function lists(){
			echo '您已经支付成功！！！';
		}

		/**
		 * 异步返回结果  支付宝
		 */
		public function alipay_notify(){
			$Pay = new Pay;
			$result = $Pay->notify_alipay();
			exit($result);
		}	
		/**
		 * 银联支付
		 */
		public function MyUnionPay($data){
			
			//实例化模型
			$pay = new Pay;
			
			//判断用户是否登录
			$a = 1;
			$line = $pay ->isOnLine($a);
			
			if($line){  //已经登录
				//判断是否实名制
				$res = json_decode($pay->isAutonym($data['uid']),true);
				if($res['code'] == 200){ //已经实名
					//判断是否绑定银行卡
					$binding = json_decode($pay->isCardBinding($data['uid']),true);
					if($binding['code'] == 2003){ //已经绑定
						//进行支付
						//以下业务逻辑与其他支付方式大致相同  可以在下方写
						return [ 
							'code' => 2009,
							'msg'  => '请选择银行卡支付！！！',
						];
					}else{ //没有绑定
						return $binding;
					}
				}else{ //没有实名
					return $res;
				}
			}else{ //没有登录
				$arr = [
					'code' => 2002,
					'msg'  => '没有登录，请您登录',
				];
				return $arr;
			}
		}
		/**
		 * 我的银行卡
		 */
		public function MyCard(){
			//获取到用户ID
			$uid = Request::instance()->param('uid');
			
			//实例化模型
			$pay = new Pay;
			//获取我的银行卡数据
			$msg = $pay ->getMyCard($uid);
			
			return Request::instance()->param('card')."(".$msg.")";
		}
		/**
		 * 引导用户进行绑定银行卡
		 */
		public function addCard(){
			//接值
			$data = Request::instance()->param();

			//实例化模型
			$pay = new Pay;
			//验证银行卡
			//$validate = $pay ->validateCard($data);
			
			//添加新的银行卡
			// $cardData = $pay->selCard($data['number']);
			// $cardData = json_decode($cardData,true);
			// $data['open_bank'] = $cardData['data']['bank_name'];
			//因为接口收费 暂时注释  给个死值
			$data['open_bank'] = '中国建设银行';
			$msg = $pay->addCard($data);

			return Request::instance()->param('addCard')."(".$msg.")";
		}
		 /*
     * 订单状态修改
     *
     */
   
		 
}