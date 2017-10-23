<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Goods extends Base
	{

		public function _initialize()
		{
			// 免登录动作列表
			$this->nologin = array(
				'payok',''
			);
			parent::_initialize();
		}

		/**
		 * 产品列表
		 * 
		 */
		public function goods_list()
		{
			// 产品的根类ID
			$cat_id = Request::instance()->param('cat_id');
			$mc_id = Request::instance()->param('mc_id');
			// 默认查询所有子类,没有附加条件
			$find_son_cat = true;
			$other = '';
			// 如果是post
			if (Request::instance()->isPost())
			{
				$param = Request::instance()->param();
				$son_id = $param['son_id'];
				$min_price = $param['min_price'];
				$max_price = $param['max_price'];
				$this->assign([
					'select_id' => $son_id,
					'min_price' => $min_price,
					'max_price' => $max_price,
				]);
				// 具体分类不为空,则按照具体分类查询
				if ($param['son_id'])
				{
					$goods_cat_id = $son_id;
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
				// 获取额外的查询条件
				$other = "AND g.price between $min_price and $max_price ";
			}
			else
			{
				// 重置筛选条件
				$select_id = 0;
				$min_price = '';
				$max_price = '';
				$this->assign([
					'select_id' => $select_id,
					'min_price' => $min_price,
					'max_price' => $max_price,
				]);
			}
			$city_id = session('position.city_id');  // 城市ID
			$uid = $this->user_id; // 用户ID
			// 确定模型,从而确定查询的表格
			$basemodel = session('basemodel');
			$model_id = Request::instance()->param('model_id') ?: $basemodel['id'];
			$this->assign("model_id", $model_id);
			switch ($model_id)
			{
				case 1:
					// 养殖户的具体分类,确定select框的value和name以及当前选中项
					$cats = Db::name('category')->where("pid = $cat_id")->select();
					$this->assign('son_cat', $cats);
					// 查询我的上架 养殖产品
					$goods_cat_id = !empty($goods_cat_id) ? $goods_cat_id : $cat_id;
					$sql = getGoodsWhere('area', $city_id, $uid, $goods_cat_id, $find_son_cat, $other);
					$my_goods = Db::name('Goods')->alias('g')
						->join('foo_region r', 'g.area = r.region_id', 'LEFT')
						->join('foo_user u', 'g.user_id = u.id', 'LEFT')
						->join('foo_category c', 'g.cat_id = c.id', 'LEFT')
						->where('g.model_id = 1 ')
						->where($sql)
						->order('r.region_id')
						->field('g.*,r.region_name,u.NAME user_name,c.NAME cat_name')
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;
				case 2:
					// 厂商户的具体分类,确定select框的value和name以及当前选中项
					$cats = Db::name('market_cat')->where("pid = $mc_id")->select();
					$this->assign('son_cat', $cats);
					// 查询我的上架 厂商产品 
					$goods_cat_id = !empty($goods_cat_id) ? $goods_cat_id : $cat_id;
					$sql = getGoodsWhere2('area', $city_id, $uid, $goods_cat_id, $find_son_cat, $other);
					$my_goods = Db::name('Goods')->alias('g')
						->join('foo_region r', 'g.area = r.region_id', 'LEFT')
						->join('foo_user u', 'g.user_id = u.id', 'LEFT')
						->join('market_cat c', 'g.cat_id = c.id', 'LEFT')
						->where('g.model_id = 2 ')
						->where($sql)
						->order('r.region_id')
						->field('g.*,r.region_name,u.NAME user_name,c.NAME cat_name')
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;
				case 3:

					break;
				case 4:

					break;

				default:
					break;
			}
			$this->assign('list', $my_goods);
			$this->assign('paginate', $my_goods->render());
			return $this->fetch();
		}

		/**
		 * 添加商品上架
		 */
		public function add_goods()
		{

			$map = Request::instance()->param();
			$map['model_id'] = $this->model_id; //确定模型分类，便于多身份用户进入时只看自己当前模型下发布的产品
			$map['user_id'] = $this->user_id;

			$map['pro'] = session('position.pro_id');
			$map['city'] = session('position.city_id');
			$map['area'] = session('position.area_id');
			$map['add_time'] = time();
			$map['total'] = input('num') * input('price');
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

		// 购买
		public function buy()
		{

			// 产品的根类ID
			$cat_id = Request::instance()->param('cat_id')?:session('cat_id');
			$mc_id = Request::instance()->param('mc_id')?:session('mc_id');
			// 存入session,用于支付宝回跳回本页面
			session('cat_id',$cat_id);
			session('mc_id',$mc_id);
			// 默认查询所有子类,没有附加条件
			$find_son_cat = true;
			$other = '';
			// 如果是post
			if (Request::instance()->isPost())
			{
				$param = Request::instance()->param();
				$son_id = $param['son_id'];
				$min_price = $param['min_price'];
				$max_price = $param['max_price'];
				$this->assign([
					'select_id' => $son_id,
					'min_price' => $min_price,
					'max_price' => $max_price,
				]);
				// 具体分类不为空,则按照具体分类查询
				if ($param['son_id'])
				{
					$goods_cat_id = $son_id;
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
				// 获取额外的查询条件
				$other = "AND g.price between $min_price and $max_price ";
			}
			else
			{
				// 重置筛选条件
				$select_id = 0;
				$min_price = '';
				$max_price = '';
				$this->assign([
					'select_id' => $select_id,
					'min_price' => $min_price,
					'max_price' => $max_price,
				]);
			}
			$city_id = session('position.city_id');  // 城市ID
			// 抢单类型,根据所访问入口的基础模型判断,而不是当前用户的模型判断
			// 故使用acc_model_id而不使用model_id
			// 同时避免覆盖session,防止混淆当前用户模型
			$model_id = Request::instance()->param('acc_model_id');
			switch ($model_id)
			{
				case 1:
					// 养殖户的具体分类,确定select框的value和name以及当前选中项
					$cats = Db::name('category')->where("pid = $cat_id")->select();
					$this->assign('son_cat', $cats);
					// 查询我的上架 养殖产品
					$goods_cat_id = !empty($goods_cat_id) ? $goods_cat_id : $cat_id;
					$sql = getGoodsWhere('area', $city_id, 0, $goods_cat_id, $find_son_cat, $other);
					$my_goods = Db::name('Goods')->alias('g')
						->join('foo_region r', 'g.area = r.region_id', 'LEFT')
						->join('foo_user u', 'g.user_id = u.id', 'LEFT')
						->join('foo_category c', 'g.cat_id = c.id', 'LEFT')
						->where('g.model_id = 1 ')
						->where($sql)
						->order('r.region_id')
						->field('g.*,r.region_name,u.NAME user_name,c.NAME cat_name')
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;
				case 2:
					// 厂商户的具体分类,确定select框的value和name以及当前选中项
					$cats = Db::name('market_cat')->where("pid = $mc_id")->select();
					$this->assign('son_cat', $cats);
					// 查询我的上架 厂商产品 
					$goods_cat_id = !empty($goods_cat_id) ? $goods_cat_id : $mc_id;
					$sql = getGoodsWhere2('area', $city_id, 0, $goods_cat_id, $find_son_cat, $other);
					$my_goods = Db::name('Goods')->alias('g')
						->join('foo_region r', 'g.area = r.region_id', 'LEFT')
						->join('foo_user u', 'g.user_id = u.id', 'LEFT')
						->join('market_cat c', 'g.cat_id = c.id', 'LEFT')
						->where('g.model_id = 2 ')
						->where($sql)
						->order('r.region_id')
						->field('g.*,r.region_name,u.NAME user_name,c.NAME cat_name')
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;
				case 3:

					break;
				case 4:

					break;

				default:
					break;
			}
			$this->assign('list', $my_goods);
			$this->assign('paginate', $my_goods->render());
			return $this->fetch();
		}
		
		// 制作订单便于填写
		public function make_order()
		{
			$order_data = Request::instance()->param();
			$order_data['buyer_id'] = $this->user_id;
			//生成订单号
			$snno = date('YmdHis') . rand(1000, 9999);
			$this->assign('data', $order_data);
			$this->assign('snno', $snno);
			return $this->fetch();
		}
		
		// 写入订单到数据库,并提交到支付宝平台
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
					$goods_id = $map['goods_id'] = $_POST['goods_id']; //产品号
					$map['pro'] = $_POST['pro']; //省
					$map['city'] = $_POST['city']; //市
					$map['area'] = $_POST['area']; //区
					$map['buyer_id'] = $_POST['buyer_id']; //购买人ID
					$map['seller_id'] = $_POST['seller_id']; //供货人ID
					$map['seller_name'] = $_POST['seller_name']; //供货人姓名

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

					$order_id = Db::name('order')->insertGetId($map);
					// 暂存入session,用于更改订单状态时使用，临时购物车
					session("order_id",$order_id);
					session("goods_id",$goods_id);

					$payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
					$payRequestBuilder->setBody($body);
					$payRequestBuilder->setSubject($subject);
					$payRequestBuilder->setOutTradeNo($out_trade_no);
					$payRequestBuilder->setTotalAmount($total_amount);
					$payRequestBuilder->setTimeExpress($timeout_express);

					$payResponse = new \AlipayTradeService($config);
					$result = $payResponse->wapPay($payRequestBuilder, $config['return_url'], $config['notify_url']);
				}
			}
		}

		public function payok()
		{
			$this->redirect('buy');
			die;
			// 暂存入session,用于更改订单状态时使用，临时购物车
			$order_id = session("order_id");
			$goods_id = session("goods_id");
			// 启动事务
			Db::startTrans();
			try
			{
				// 更新订单状态
				Db::name('order')->where("id = $order_id")->update(['pay_status' => 1]);
				// 产品下架
				Db::name('Goods')->where("id = $goods_id")->update(['on_sell' => 0]);
				// 提交事务
				Db::commit();
				// 清空临时购物车
				session("order_id",null);
				session("goods_id",null);
			}
			catch (\Exception $e)
			{
				// 回滚事务
				Db::rollback();
				$this->error('订单提交失败,请联系管理员','buy');
			}
			$this->redirect('buy');
		}

	}
	