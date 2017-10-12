<?php

	namespace app\home\controller;

	use think\Controller;
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
			$baseid = $this->request->param('cat_id');
			$basemodel = Db::name('Basemodel')->find($baseid);
			// 备用
			session('basemodel', $basemodel);

			// 系统所有业务分类
			$categorys = Db::name('category')->select();
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
			$this->assign('auth_catid', $auth_catid);

			// 获取绑定的所有分类
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);

			// 根据基础认证模型确定要填写的表单 1为饲养户，2为厂区，3为专家，4为
			$model_id = session('basemodel.id');
			//$tpl_name = 'auth_tpl_' . $model_id;
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
			$map['cat_id'] = $post_data['cat_id'];
			$map['card_no'] = $post_data['card_no'];
			// 默认未通过审核
			$map['is_auth'] = 0;
			
			// 根据认证分类确定模型
			$model_id = $this->request->param('model_id');

			switch ($model_id)
			{
				//饲养户
				case 1:
					// 容量信息
					$map['capacity'] = $post_data['capacity'];
					break;
				//厂区拥有者
				case 2:
					// 营业执照编号
					$map['license'] = $post_data['license'];
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
					if($save){
						// 组装路径用于写入数据库
						$map[$key]= $path . DS . $save->getSaveName();
					}else{
						return $save->getError();
					}
				}
			}
			// 表名
			$table_name = Db::name('Basemodel')->where('id',$model_id)->value('table_name');
			if(Db::name($table_name)->insert($map)){
				$this->success('申请成功，请等待审核', 'index');
			}
			else{
				$this->error('申请失败，请联系管理', 'index');
			}
			//return $this->fetch();
		}

		public function detail()
		{
			$cat_id = $this->request->param('cat_id');
			if (is_authed($cat_id))
			{
				return $this->fetch();
			}
			else
			{
				$model_name = session('basemodel.table_name');
				$uid = $this->user_id;
				$map['user_id'] = $uid;
				$map['cat_id'] = $cat_id;
				$map['is_auth'] = 0;
				if(Db::name($model_name)->where($map)->select()){
					return $this->error('您的信息正在认证中,请耐心等待');
				}else{
					return $this->error('您尚未认证所需信息', "auth?cat_id={$cat_id}");
				}
			}
		}

	}
	