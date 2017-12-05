<?php
namespace app\index\model;

use think\Db;
use think\Model;
use think\Validate;
use think\Log;

class Pay extends Model
{
	private $appkey = '0406c2b001fdb3f6d69ee34066b11a9d';
	public $bankStatus = 1;  //银行卡的类型
	public $status = 0;  // 订单的支付状态
	//支付宝第三方接口的配置
	public static $alipay_config = [
		'partner' 			=> '2088121321528708',//支付宝partner，2088开头数字
		'seller_id' 		=> '2088121321528708',//支付宝partner，2088开头数字
		'key' 				=> '1cvr0ix35iyy7qbkgs3gwymeiqlgromm',//支付宝密钥
		'sign_type' 		=> 'MD5',
		'input_charset' 	=> 'utf-8',
		'cacert' 			=> '',
		'transport' 		=> 'http',
		'payment_type' 		=> '1',
		'service' 			=> 'create_direct_pay_by_user',
		'anti_phishing_key'	=> '',
		'exter_invoke_ip' 	=> '',
	];



	/**
	 * 查询订单的信息
	 */
	public function GetOrderInfo($oid,$uid){
		
		//使用Query对象查询
		$list = new \think\db\Query;
		$query = $list ->name('p_order')
			->where('oid',$oid)
			->where('uid',$uid)
			->where('status',$this->status);
		$arr = \think\Db::find($query);
		
		return $arr;
	}

	/**
	 * 根据订单号查询订单信息
	 */
	 public function GetOrderData($ordernumber){
		$this->status = 0;
		$orderData = Db::table('p_order')
			->where('ordernumber',$ordernumber)
			->where('status',$this->status)
			->find();
		return $orderData;
	 }

	/**
	 * 查询当前用户的余额
	 */
	 public function getMoney($uid){
		$list = new \think\db\Query;
		$query = $list->name('p_userinfo')
			->field('money')
			->where('uid','eq',$uid);
		$money = \think\Db::find($query);
		return $money['money'];
	 }

	 /**
	  * 查询正在投资的产品的一条信息
	  */
	  public function getShopInfo($sid){
		  $list = \think\Db::table('p_shop')
			  ->where('sid',$sid)
			  ->field('intermoney')
		      ->find();
		  return $list['intermoney'];
	  }

	/**
	  * 更新已投资的金额
	  */
	public function UpInterMoney($data){

		//查询出当前的商品已投资的金额
		$shopMoney = $this->getShopInfo($data['sid']);
		//字段更新
		$shopMoney = $shopMoney + $data['money'];
		
		//执行更新
		$res = Db::table('p_shop')
			->where('sid',$data['sid'])
			->update(['intermoney'=>$shopMoney]);

		if($res) return true;
		else return false;
	}

	/**
	 * 插入到交易记录表
	 */
	 public function AddRecord($data){
		 return Db::table('p_record')->insertGetId($data);
	 }

	 /**
	  * 更新用户余额
	  */
	 public function UpUserMoney($uid,$money){
		$userInfo = $this->getMoney($uid);
		
		$userInfo = $userInfo - $money;
		$res = Db::table('p_userinfo')
			->where('uid',$uid)
			->update(['money' => $userInfo]);
		if($res) return true;
		else return false;
	 }

	 /**
	  * 更新订单状态
	  */
	  public function UpOrderStatus($uid,$oid,$pt){
		  $orderData = $this->GetOrderInfo($oid,$uid);

		  $this->status = 1;

		  $res = Db::table('p_order')
			  ->where('oid',$orderData['oid'])
			  ->update([
				'status' => $this->status,
			    'payType'=> $pt,
			  ]);
		  if($res>0){
			return true;
		  }else{
			return false;
		  }
	  }
	
	//支付的状态 
	public function alipay($data=[])
	{
		$config = self::$alipay_config;   //调用配置信息
		
		vendor('alipay.alipay'); //调用vendor 下的alipay下的alipay文件  也可以使用import  但是要放在 extend目录下
		

		//支付宝 alipayapi.php文件中 需要的参数数组  
		$parameter = [
			"service"       	=> $config['service'],
			"partner"       	=> $config['partner'],
			"seller_id"  		=> $config['seller_id'],
			"payment_type"		=> $config['payment_type'],
			"notify_url"		=> $data['notify_url'],
			"return_url"		=> $data['return_url'],
			"anti_phishing_key"	=> $config['anti_phishing_key'],
			"exter_invoke_ip"	=> $config['exter_invoke_ip'],
			"out_trade_no"		=> $data['out_trade_no'],
			"subject"			=> $data['subject'],
			"total_fee"			=> $data['total_fee'],
			"body"				=> $data['body'],
			"_input_charset"	=> $config['input_charset']
		];

		//这部分代码取自 alipayapi.php
		$alipaySubmit = new \AlipaySubmit($config);
		return ['code'=>2001,'msg'=>$alipaySubmit->buildRequestForm($parameter,"get", "确认")];
	}

	/**
	 * 处理同步通知
	 */
	 public function return_alipay($mstatus){
		
		vendor('alipay.alipay');
		$config = self::$alipay_config;
		$alipayNotify = new \AlipayNotify($config);
		//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

		//商户订单号
		$out_trade_no = $_GET['out_trade_no'];

		//支付宝交易号
		$trade_no = $_GET['trade_no'];

		//交易状态
		$trade_status = $_GET['trade_status'];
		
		//判断订单的支付状态
		if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
			echo '<script>alert("支付成功")</script>';
			
			//查询订单的信息
			$orderData = $this->getOrderData($out_trade_no);
			//1.更新订单状态
			$this->payType = 1;
			$res = $this->UpOrderStatus($orderData['uid'],$orderData['oid'],$this->payType);

			if($res){  //判断更改订单状态是否成功
				//2.增加商品表中的已投资金额
				$resUserMoney = $this->UpInterMoney($orderData);
				if($resUserMoney){ //判断是否更新商品表的已投资金额
				//3.组装要入库的数据
					$data = [
						'uid' => $orderData['uid'],
						'mstatus' => $mstatus,
						'money' => $orderData['money'],
						'sid' => $orderData['sid'],
					];

					//4.插入投资记录表中
					if($this->AddRecord($data)) return true;
					else return false;
				}else{
					return false;	
				}
			}
		}
		else {
			return false;
		}
	 }

	/**
	 * 处理异步通知
	 */
	public function notify_alipay()
	{
		$config = self::$alipay_config;
		vendor('alipay.alipay');
		$alipayNotify = new \AlipayNotify($config);
		if($result = $alipayNotify->verifyNotify()){
			if(input('trade_status') == 'TRADE_FINISHED' || input('trade_status') == 'TRADE_SUCCESS') {
				// 处理支付成功后的逻辑业务
				Log::init([
					'type'  =>  'File',
					'path'  =>  LOG_PATH.'../paylog/'
				]);
				Log::write($result,'log');
				return 'success';
			}
			return 'fail';
		}
		return 'fail';
	}

	/**
	 * 判断用户是否实名
	 */
	 public function isAutonym($uid){
		 
		$autonym = Db::table('p_userinfo')
	 		->where('uid',$uid)
			->field('is_autonym')
			->find();
		if($autonym['is_autonym'] == 1){
			$res = [
				'code' => 200,
				'msg'  => '已经实名制',
				'data' => $autonym['is_autonym'],
			];
		}else if($autonym['is_autonym'] == 0){
			$res = [
				'code' => 2004,	
				'msg'  => '没有实名，请您实名绑定一下',
			];
		}

		return json_encode($res);
	 }

		/**
		 * 判断银行卡是否绑定
		 * @return array $msg 返回的数组 
		 */
		public function isCardBinding($uid){
			$bankList = Db::table('p_bankcard')
				->where('uid',$uid)
				->where('type',$this->bankStatus)
				->select();

			if($bankList){
				$msg = [
					'code' => 2003,
					'msg'  => '请选择银行卡支付',
					'data' => $bankList,
				];
			}else{
				$msg = [
					'code' => 2005,	
					'msg'  => '银行卡没有绑定，请进行绑定！！！',
				];
			}
			return json_encode($msg);
		}


		/**
		 * 查询用户绑定的银行卡 
		 */
		public function getMyCard($uid){
			$cardData = Db::table('p_bankcard')
				->where('uid',$uid)
				->where('type',$this->bankStatus)
				->select();
			if($cardData){
				$msg = [
					'code' => 2009,
					'msg'  => '查询到我的银行卡',
					'data' => $cardData,
				];
			}else{
				$msg = [
					'code' => 2010,
					'msg'  => '您当前没有用户卡 请绑定新卡',
				];
			}

			return json_encode($msg);
		}

		/**
		 * 调用第三方接口 验证银行卡信息
		 */
		public function validateCard($data){
			
			header("Content-type: application/json; charset=utf-8");
			
			$params = array(
				'accName' => $data['realname'],
				'cardHolderName' => $data['tel'],
				'idCardNo' => $data['idCard'],
				'bankCardNo' => $data['number'],
				'appkey' => $this->appkey,
			);
			 $url = 'https://way.jd.com/iBEETechnologies/elementFour';
			return $this->wx_http_request($url, $params );
			
		}

		/**
		 * 京东万象的SDK
		 */
		public function wx_http_request($url, $params, $body="", $isPost=false, $isImage=false ) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url."?".http_build_query($params));
			if($isPost){
				if($isImage){
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Content-Type: multipart/form-data;',
							"Content-Length: ".strlen($body)
						)
					);
				}else{
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Content-Type: text/plain'
						)
					);
				}
				curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			}
			$result = curl_exec($ch);
			curl_close($ch);
			return $result;
		}
		
		/**
		 * 调用第三方接口 查询银行卡的信息
		 */
		public function selCard($number){
			header("Content-type: application/json; charset=utf-8");
			$params = array(
				'bankno' => $number,
				'appkey' => $this->appkey,
			);
			$url = 'https://way.jd.com/yingyan/bankcardinfo';
			return $this->wx_http_request($url, $params );
		}

		/**
		 * 绑定新的银行卡
		 */
		public function addCard($data){
			//拼装数据
			$bankData = [
				'uid' => $data['uid'],
				'type' => $this->bankStatus,
				'open_bank' => $data['open_bank'],
				'tel'    => $data['tel'],
				'number' => $data['number'],
			];

			$id = Db::table('p_bankcard')->insertGetId($bankData);
			if($id){
				$msg = [
					'code' => 2011,
					'msg'  => '绑卡成功',
				];
			}else{
				$msg = [
					'code' => 2012,
					'msg'  => '绑卡失败',
				];
			}
			return json_encode($msg);
		}





	/**
	 * 模拟测试 用户是否登录  （此接口只用于测试）
	 */
	 public function isOnLine($a){
		if($a == 1){
			return true;
		}else if($a == 0){
			return false;
		}		 
	 }
}