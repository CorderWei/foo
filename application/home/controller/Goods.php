<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	//use app\home\model\Goods;

	class Goods extends Controller
	{

		public function _initialize()
		{
			parent::_initialize();
			if (session('?user'))
			{
				$user = session('user');
				$user = Db::name('User')->where("id", $user['id'])->find();
				session('user', $user);  //覆盖session 中的 user               
				$this->user = $user;
				$this->user_id = $user['id'];
				$this->assign('user', $user); //存储用户信息
				$this->assign('user_id', $this->user_id);
			}
			else
			{
				// 免登录动作列表
				$nologin = array(
				);
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Home/Index/login');
					exit;
				}
			}
			// 获取用户所选(所在)当前城市名称
			$cur_city = GetCurrentCityName();
			$this->assign('cur_city', $cur_city);
		}
		
		/**
		 * 产品列表
		 * 
		 */
		public function goods_list()
		{
			$city_id = session('position.city_id');  // 城市ID
			$uid = $this->user_id; // 用户ID
			// 查询允许添加上架的分类
			$cat_id = Request::instance()->param('cat_id')?:session('category'); //产品父级ID
			// 基础模型信息,因2,3,4模型均不涉及业务子类，需要父类直接标记
			$model_id = Request::instance()->param('model_id')?:session('basemodel.id');
			if (!empty($cat_id))
			{
				$son_cat = Db::name('Category')->where("pid = $cat_id")->select();
			}
			else
			{
				if (!empty($model_id))
				{
					// 根据模型确定原始信心中规定的分类编号,基础模型和基础业务分类不可删除
					switch ($model_id)
					{
						case 5:
							$cat_id = 12;
							break;
						case 6:
							$cat_id = 19;
							break;
						default:
							break;
					}
					$son_cat = Db::name('Category')->where("pid = $cat_id")->select();
				}
				else
				{
					$son_cat = [];
				}
			}
			$this->assign('son_cat', $son_cat);
			// post方式用于筛选
			if (Request::instance()->isPost())
			{
				$param = Request::instance()->param();
				// 默认查询所有子类
				$find_son_cat = true;
				$son_id = $param['son_id'];
				$min_price = $param['son_id'];
				$max_price = $param['min_price'];
				// 具体分类不为空,则按照具体分类查询
				if ($param['son_id'])
				{
					$cat_id = $son_id;
					$find_son_cat = false;
				}
				if (empty($min_price))
				{
					$min_price = 0;
				}
				if (empty($max_price))
				{
					$max_price = 0x3f3f3f3f;
				}
				
				$other = "AND g.price between $min_price and $max_price ";
				$sql = getGoodsSql('area', $city_id, $uid, $cat_id, $find_son_cat, $other);
				$my_goods = Db::query($sql);
				$this->assign('select_id', $cat_id);
				$this->assign('list', $my_goods);
				return $this->fetch();
			}
			else
			{
				// 查询我的上架产品
				$sql = getGoodsSql('area', $city_id, $uid, $cat_id, true);
				$my_goods = Db::query($sql);
				// 过滤条件默认选中项
				$select_id = 0;
				$this->assign('select_id', $select_id);
				$this->assign('list', $my_goods);
				return $this->fetch();
			}
		}

		/**
		 * 添加商品上架
		 */
		public function add_goods()
		{

			$map = Request::instance()->param();
			$map['user_id'] = $this->user_id;
			$map['pro'] = session('position.pro_id');
			$map['city'] = session('position.city_id');
			$map['area'] = session('position.area_id');
			$map['add_time'] = time();
			$map['on_sell'] = 1;
			if (Db::name('Goods')->insert($map))
			{
				$this->success('商品上架成功');
			}
			else
			{
				$this->error('系统繁忙，请您稍后');
			}
		}

		public function buy()
		{
			// 查询所有的上架产品
			$city_id = session('position.city_id');  // 城市ID
			$cat_id = Request::instance()->param('cat_id'); //产品ID
			$sql = getGoodsSql('area', $city_id, 0, $cat_id, true);
			$goods = Db::query($sql);
			// 计算总价添加到数组中
			foreach ($goods as $key => $value)
			{
				$goods[$key]['total'] = $value['price'] * $value['num'];
			}
			$this->assign('list', $goods);
			return $this->fetch();
		}

		public function make_order()
		{
			$order_data = Request::instance()->param();
			//生成订单号
			$snno = date('YmdHis') . rand(1000, 9999);
			$this->assign('data', $order_data);
			$this->assign('snno', $snno);
			// 生成订单写入库  状态未付款
			return $this->fetch();
		}

		public function dobuy()
		{
			if (Request::instance()->isPost())
			{
				// 支付宝逻辑
				header("Content-type: text/html; charset=utf-8");
				require_once APP_PATH . 'AliPay/wappay/service/AlipayTradeService.php';
				require_once APP_PATH . 'AliPay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
				require APP_PATH . 'AliPay/config.php';
				if (!empty($_POST['WIDout_trade_no']) && trim($_POST['WIDout_trade_no']) != "")
				{
					//商户订单号，商户网站订单系统中唯一订单号，必填
					$out_trade_no = $_POST['WIDout_trade_no'];

					//订单名称，必填
					$subject = $_POST['WIDsubject'];

					//付款金额，必填
					$total_amount = $_POST['WIDtotal_amount'];

					//商品描述，可空
					$body = $_POST['WIDbody'];

					//超时时间
					$timeout_express = "1m";

					// 存储一个未支付的订单，状态码 0 未付款, 1已付款
					$map['out_trade_no'] = $_POST['WIDout_trade_no']; //订单号
					$map['cat_name'] = $_POST['WIDsubject']; //商品名称
					$map['cat_id'] = $_POST['WIDbody']; //规格
					$map['price'] = $_POST['WIDprice']; //价格
					$map['num'] = $_POST['WIDnum'];  //数量
					$map['total'] = $_POST['WIDtotal_amount']; //总计金额
					$map['mobile'] = $_POST['WIDmobile']; //联系电话
					$map['address'] = $_POST['WIDaddress']; //联系地址
					$map['remark'] = $_POST['WIDremark'];  //备注
					date_default_timezone_set('PRC');
					$map['add_time'] = time();
					$map['pay_status'] = 0;
					$map['ship_status'] = 0;

					$payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
					$payRequestBuilder->setBody($body);
					$payRequestBuilder->setSubject($subject);
					$payRequestBuilder->setOutTradeNo($out_trade_no);
					$payRequestBuilder->setTotalAmount($total_amount);
					$payRequestBuilder->setTimeExpress($timeout_express);

					$payResponse = new \AlipayTradeService($config);
					$result = $payResponse->wapPay($payRequestBuilder, $config['return_url'], $config['notify_url']);
					if ($result)
					{
						$map['pay_status'] = 1;
					}
					// 更新订单状态为已付款
//					if (Db::name('Order')->insert($map))
//					{
//						
//					}
					//M('order')->add($map);			
					return $this->fetch();
				}
			}
		}

	}
	