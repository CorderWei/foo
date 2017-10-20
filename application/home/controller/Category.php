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

		// 模型分类认证信息展示
		public function auth()
		{
			// 要认证的分类
			$auth_catid = input('cat_id');
			if (empty($auth_catid))
			{
				$auth_catid = 0;
			}
			var_dump($auth_catid);
			$this->assign('auth_catid', $auth_catid);

			// 获取绑定的所有分类
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);

			// 根据基础认证模型确定要填写的表单 1为饲养户，2为厂区，3为专家，4为运输
			$model_id = session('basemodel.id');
			$this->assign('model_id', $model_id);
			return $this->fetch('auth_tpl');
		}

		// 模型分类认证
		public function doauth()
		{
			// 根据认证分类确定模型
			$model_id = $this->request->param('model_id');

			$post_data = $this->request->param();
//			dump($post_data['cat_id']);
//			// 如果已经提交了验证信息则回退
//			if(true){
//				$this->error('您已经提交了验证信息','category/index', ['model_id'=>$model_id]);
//			}
			// 公共信息
			$map['user_id'] = $post_data['user_id'];
			$map['name'] = $post_data['name'];
			$map['phone'] = $post_data['phone'];
			$map['address'] = $post_data['address'];
			$map['pro'] = $post_data['pro'];
			$map['city'] = $post_data['city'];
			$map['area'] = $post_data['area'];
			$map['card_no'] = $post_data['card_no'];
			// 默认未通过审核
			$map['is_auth'] = 0;



			switch ($model_id)
			{
				//饲养户
				case 1:
					// 业务方向,容量信息
					$map['cat_id'] = $post_data['cat_id'];
					$map['capacity'] = $post_data['capacity'];
					break;
				//厂区拥有者, 暂不用父级分支, 跳入5,6
				case 2:

					break;
				//专家
				case 3:
					$map['school_name'] = $post_data['school_name'];
					$map['school_address'] = $post_data['school_address'];
					$map['license'] = $post_data['license'];
					$map['intro'] = $post_data['intro'];
					break;
				// 运输车
				case 4:
					$map['car_no'] = $post_data['car_no'];
					$map['radius'] = $post_data['radius'];
					$map['car_license'] = $post_data['car_license'];
					break;
				case 5:
				case 6:
					// 营业执照编号，子模型编号(兽药，饲料)
					$map['model_id'] = $model_id;
					$map['license'] = $post_data['license'];
				default:
					break;
			}

			// 图片上传部分
			$pic_array = ['owner_pic', 'market_pic', 'car_pic']; // 设定允许上传的字段
			$files = $this->request->file();
			foreach ($files as $key => $value)
			{
				if (in_array($key, $pic_array))
				{
					// 存储路径
					$path = '/uploads' . DS . "$key";
					// 执行存储
					$save = $value->
						validate(['size' => 2097152, 'ext' => 'jpg,png,gif'])->
						move(ROOT_PATH . 'public' . $path);
					if ($save)
					{
						// 组装路径用于写入数据库
						$map[$key] = $path . DS . $save->getSaveName();
					}
					else
					{
						return $save->getError();
					}
				}
			}
			// 表名
			$table_name = Db::name('Basemodel')->where('id', $model_id)->value('table_name');
			if (Db::name($table_name)->insert($map))
			{
				$this->success('申请成功，请等待审核', url('index', ['model_id' => $model_id]));
			}
			else
			{
				$this->error('申请失败，请联系管理', url('index', ['model_id' => $model_id]));
			}
			//return $this->fetch();
		}

		// 二级入口列表，时间关系暂不列入后台维护范畴，相应的根入口必须为不可变动
		public function detail()
		{
			$this->authCheck();
			$model_id = $this->model_id;
			dump($model_id);
			$cat_id = $this->request->param('cat_id');
			// 列举厂商分类的入口
			$market_cats = Db::name('Market_cat')->where('pid = 0')->select();
			$this->assign("market_cats",$market_cats);
			
			if (is_authed($cat_id))
			{
				$this->assign('cat_id', $cat_id);
				return $this->fetch();
			}
			else
			{
				$table_name = session('basemodel.table_name');
				$model_id = session('basemodel.id');
				$uid = $this->user_id;
				$map['user_id'] = $uid;
				// 只有养殖户分具体类别
				if ($model_id == 1)
				{
					$map['cat_id'] = $cat_id;
				}
				$map['is_auth'] = 0;
				if (Db::name($table_name)->where($map)->select())
				{
					return $this->error('您的信息正在认证中,请耐心等待');
				}
				else
				{
					return $this->error('您尚未认证所需信息', "auth?cat_id={$cat_id}");
				}
			}
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
	