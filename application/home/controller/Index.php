<?php

	namespace app\home\controller;
	
	use think\Request;
	use think\Db;
	use think\Loader;
	use app\home\controller\Base;
	use app\home\model\User;
	use app\home\model\Article;

	class Index extends Base
	{

		public function _initialize()
		{
			$this->nologin = array(
				'login', 'dologin', 'logout', 'register', 'doregister', 'changepass', 'index', 'note_city',
				'citychange',
			);
			parent::_initialize();
			// 模型定位
			$this->model_id = Request::instance()->param('model_id')?:session('basemodel.id');
			if(!empty($this->model_id)){
				$basemodel = Db::name('basemodel')->find($this->model_id);
				if($basemodel){
					session('basemodel',$basemodel);
				}
			}
			dump(session('basemodel'));
		}

		public function index()
		{
			// 获取坐标位置
			// 轮播管理
			// 入口分类
			// 按照认证模型
			$models = Db::name('basemodel')->where('pid = 0')->select();
			$this->assign('interfaces', $models);

			// 文章
			$article = new Article;
			
			// 按照用户所在城市过滤
			$region = session('position.city_id');
			$where = "region = 0 or region = $region";
			$arts = $article->where($where)->limit(6)->select();
			$this->assign('arts', $arts);
			return $this->fetch();
		}

		// 文章详情
		public function article_detail()
		{
			$id = $this->request->param('id');
			$article = Article::get($id);
			$this->assign('article', $article);
			return $this->fetch();
		}

		// 登录
		public function login()
		{
			return $this->fetch();
		}

		// 执行登录
		public function dologin()
		{
			$data = input();
			$map['name'] = $data['name'];
			$map['pass'] = MD5(MD5($data['pass']));
			$user = Db::name('User')->where($map)->find();

			//登录成功
			if ($user)
			{
				// 存储session
				session('user', $user);
				$this->success('登录成功', 'index');
			}
			else
			{
				$this->error('账号或密码错误', 'login');
			}
		}

		// 注册
		public function register()
		{
			return $this->fetch();
		}

		// 执行注册
		public function doregister()
		{
			$requset = Request::instance();
			$data = $requset->param();
			// 采用验证器验证
			$validate = Loader::validate('Index');
			if (!$validate->check($data))
			{
				$this->error($validate->getError());
			}
			// 环信用户注册
			if (!huanxin_reg($data['name'], $data['pass']))
			{
				$this->error("用户名不规范或已存在！");
			}
			// 新增用户
			$user = new User;
			$user->data([
				'name' => $data['name'],
				'hx_pass' => $data['pass'],
				'pass' => MD5(MD5($data['pass'])),
				'add_time' => time(),
			]);
			//注册成功后直接登录
			if ($user->save())
			{
				$new_user = Db::name('User')->where("id", $user->id)->find();
				session('user', $new_user);
				$this->success('注册成功', 'index');
			}
			else
			{
				$this->redirect('register');
			}
		}

		// 密码修改
		public function changepass()
		{
			// 更改
			if ($this->request->isPost())
			{
				$data = input();
				$user = $this->user;
				$u_id = $this->user_id;
				$map['name'] = $user['name'];
				$map['pass'] = MD5(MD5($data['old']));
				$u = Db::name('User')->where($map)->find();
				if ($u)
				{
					if ($data['xin'] == $data['que'])
					{
						$d['pass'] = MD5(MD5($data['xin']));
						Db::name('User')->where("id = $u_id")->update($d);
						$this->success('密码修改成功,请牢记新密码');
					}
				}
				else
				{
					$this->error('原始密码错误');
				}
			}
			// 展示
			else
			{
				return $this->fetch();
			}
		}

		// 退出登录
		public function logout()
		{
			// 用户信息
			session('user', null);
			// 位置信息
			session('position', null);
			// 认证模型信息
			session('basemodel', null);

			// 经纬度存在cookie中保留,位置信息仍留在cookie中下次使用
			$this->success('退出完毕', 'index');
		}

		// 城市切换
		public function citychange()
		{
			if (request()->isPost())
			{
				$parent_id['parent_id'] = input('post.pro_id', 'addslashes');
				$region = Db::name('Region')->where($parent_id)->select();
				$opt = '<option value=0>--请选择市区--</option>';
				foreach ($region as $key => $val)
				{
					$opt .= "<option value='{$val['region_id']}'>{$val['region_name']}</option>";
				}
				echo json_encode($opt);
			}
			else
			{
				$parent_id['parent_id'] = 1;
				$region = Db::name('Region')->where($parent_id)->select();
				$this->assign('region', $region);
				return $this->fetch();
			}
		}

		// 当前位置信息存入session和cookie
		public function note_city()
		{
			$data = input('post.');
			session('position', $data);
			cookie('position', $data);
			echo 1;
		}

		// 环信入口
		public function huanxin()
		{
			$user = $this->user;
			$name = $user['name'];
			$hx_pass = $user['hx_pass'];
			$this->redirect("/WebIm.html?name=$name&hx_pass=$hx_pass");
		}

	}
	