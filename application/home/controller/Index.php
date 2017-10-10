<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Index extends Controller
	{

		public function _initialize()
		{
			parent::_initialize();
			if (session('?user'))
			{
				$user = session('user');
				$user = M('users')->where("user_id", $user['user_id'])->find();
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
					'login', 'dologin', 'logout', 'register', 'doregister', 'changepass', 'index', 'note_city',
					'citychange',
				);
				if (!in_array($this->request->action(), $nologin))
				{
					$this->redirect('Home/Index/login');
					exit;
				}
			}
		}

		public function index()
		{
			// 获取坐标位置
			// $coord = GetCoord();
			// 获取用户所选(所在)当前城市名称
			$cur_city = GetCurrentCityName();
			$this->assign('cur_city', $cur_city);

			// 轮播
			// 入口
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);
			// 文章
			return $this->fetch();
		}

		// 登录
		public function login()
		{
			// 获取绑定的所有分类
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);

			return $this->fetch();
		}

		// 执行登录
		public function dologin()
		{
			$data = input();
			var_dump($data);
			die;

			//登录成功
			if (true)
			{
				$this->success('登录成功', 'index');
			}
			else
			{
				$this->redirect('login');
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
			//注册成功
			if (true)
			{
				$this->success('注册成功', 'index');
			}
			else
			{
				$this->redirect('register');
			}
		}

		// 退出登录
		public function logout()
		{
			
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

		// 当前位置信息存入session
		public function note_city()
		{
			$data = input('post.');
			$_SESSION['position'] = $data;
			echo 1;
		}

	}
	