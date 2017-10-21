<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Model;
	use think\Request;
	use think\Db;

	class Category extends Base
	{

		public function _initialize()
		{
			parent::_initialize();
		}

		public function index()
		{
			$categorys = Db::name('category')->where('pid = 0 AND id NOT IN (12,19)')->select();
			$this->assign('categorys', $categorys);
			return $this->fetch();
		}

		// 列举厂商分类的入口
		public function detail()
		{
			$this->authCheck();
			$market_cats = Db::name('Market_cat')->where('pid = 0')->select();
			$this->assign("market_cats",$market_cats);
			return $this->fetch();
		}

		// 我的专属(饲养户/厂商自己的统计管理,公开到行情查询中)
		public function manage()
		{
			// 提交
			if (request()->isPost())
			{
				$map = Request::instance()->param();
				$map['user_id'] = $this->user_id;
				$postion = session('position');
				$map['pro'] = $postion['pro_id'];
				$map['city'] = $postion['city_id'];
				$map['area'] = $postion['area_id'];

				if (Db::name('Manage')->insert($map))
				{
					$this->success('新增栏成功');
				}
				else
				{
					$this->error('系统繁忙，请您稍后');
				}
			}
			else
			{
				$cat_id = $this->request->param('cat_id') ?: session('category');
				// 子分类
				$son_cat = Db::name('Category')->where("pid = $cat_id")->select();
				// 已经录入的种类数量信息
				$uid = $this->user_id;
				$sql = "select * from foo_category c, foo_manage m "
					. "where m.cat_id = c.id "
					. "and m.user_id = $uid "
					. "and c.pid = $cat_id";
				$list = Db::query($sql);
				$this->assign('son_cat', $son_cat);
				$this->assign('list', $list);
			}
			return $this->fetch();
		}

		// 行情查询
		public function matter()
		{
			$cat_id = $this->request->param('cat_id');
			// 按照地区检索
			if (Request::instance()->isPost())
			{
				
			}
			// 查询当前城市
			else
			{
				$city_id = session('position.city_id');
				// 查询当前城市下当前分类下，按照二级分类统计的行情
				$sql = "SELECT
							SUM(m.num) sum, 
 							r.region_name,
							c. NAME cat_name
						FROM
							foo_manage m
						LEFT JOIN foo_category c ON (m.cat_id = c.id)
						LEFT JOIN foo_region r ON (m.area = r.region_id)
						WHERE
						1 = 1 AND m.city = $city_id ";
				if (!empty($cat_id))
				{
					$sql .= "AND m.cat_id IN (
							SELECT
								id
							FROM
								foo_category
							WHERE
								pid = $cat_id
						) ";
				}
				$sql .= " 
						GROUP BY
						region_name,cat_name";
				$matter = Db::query($sql);
				$this->assign('matter', $matter);
			}

			return $this->fetch();
		}

		// 兽药
		public function drug()
		{
			// 查询所有的上架产品
			$city_id = session('position.city_id');  // 城市ID
			$cat_id = 12; //Request::instance()->param('cat_id'); //产品ID
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

		// 饲料
		public function food()
		{
			// 查询所有的上架产品
			$city_id = session('position.city_id');  // 城市ID
			$cat_id = 19; //Request::instance()->param('cat_id'); //产品ID
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

		public function transport()
		{
			return $this->fetch();
		}

	}
	