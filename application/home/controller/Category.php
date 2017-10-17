<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Model;
	use think\Request;
	use think\Db;

	class Category extends Controller
	{

		public function _initialize()
		{
			parent::_initialize();
			if (session('?user'))
			{
				$user = session('user');
				$user = Db::name('user')->where("id", $user['id'])->find();
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
					$this->redirect('Home/Index/login');
					exit;
				}
			}
			// 获取用户所选(所在)当前城市名称
			$cur_city = GetCurrentCityName();
			$this->assign('cur_city', $cur_city);

			// 城市选择组件所需数据
			$parent_id['parent_id'] = 1;
			$region = Db::name('Region')->where($parent_id)->select();
			$this->assign('region', $region);
		}

		public function index()
		{
			// 当前基础认证模型
			$model_id = $this->request->param('model_id')?:session('basemodel.id');
			// 根据分类进入不同的界面(根据养殖户，厂商，专家，运输)
			switch ($model_id)
			{
				case 1:
					// 养殖户进入，展示所有业务类型
					$categorys = Db::name('category')->where('pid = 0 AND id NOT IN (12,19)')->select();
					$this->assign('categorys', $categorys);
					$tpl_id = 1;
					break;
				case 2:
					// 厂商，进入后再次选择业务分类 5 还是 6
					$categorys = Db::name('basemodel')->where('id IN (5,6)')->select();
					$this->assign('categorys', $categorys);
					$tpl_id = 2;
					break;
				case 3:
					// 专家
					$categorys = Db::name('category')->where('pid = 0 AND id NOT IN (12,19)')->select();
					$this->assign('categorys', $categorys);
					$tpl_id = 3;
					break;
				case 4:
					// 运输
					$tpl_id = 4;
					break;
				case 5:
				case 6:
					$categorys = Db::name('category')->where('pid = 0 AND id NOT IN (12,19)')->select();
					$this->assign('categorys', $categorys);
					$tpl_id = 5;
					break;
				default:
					break;
			}
			$this->assign('model_id', $model_id);
			return $this->fetch('index_' . $tpl_id);
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

			$post_data = $this->request->param();

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

			// 根据认证分类确定模型
			$model_id = $this->request->param('model_id');

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
					$path = 'public' . DS . 'uploads' . DS . "$key";
					// 执行存储
					$save = $value->
						validate(['size' => 2097152, 'ext' => 'jpg,png,gif'])->
						move(ROOT_PATH . $path);
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
			$model_id = $this->request->param('model_id');
			$basemodel = Db::name('Basemodel')->find($model_id);
			// 刷新当前模型值
			session('basemodel', $basemodel);
			$cat_id = $this->request->param('cat_id');
			if (is_authed($cat_id))
			{
				$this->assign('cat_id', $cat_id);
				return $this->fetch();
			}
			else
			{
				$model_name = session('basemodel.table_name');
				$uid = $this->user_id;
				$map['user_id'] = $uid;
				$map['cat_id'] = $cat_id;
				$map['is_auth'] = 0;
				if (Db::name($model_name)->where($map)->select())
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
				// 提交新增信息

				$map = Request::instance()->param();
				$map['user_id'] = $this->user_id;
				$postion = session('position');
				if ($postion)
				{
					$map['pro'] = $postion['pro_id'];
					$map['city'] = $postion['city_id'];
					$map['area'] = $postion['area_id'];
				}
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
				$cat_id = $this->request->param('cat_id')?:session('category');
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
			// 默认当前城市
			else
			{
				if ($position = session('position'))
				{
					$city_id = $position['city_id'];
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
					// 
					$city_name = $position['city_name'];
					$this->assign('city_name', $city_name);
				}
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

		// 附近会员
		public function near()
		{
			return $this->fetch();
		}

	}
	