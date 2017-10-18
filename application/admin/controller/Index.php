<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Index extends Controller
	{

		public function _initialize()
		{
			parent::_initialize();
			if (session('?admin'))
			{
				$admin = session('admin');
				$admin = Db::name('Admin')->where("id", $admin['id'])->find();
				session('admin', $admin);  //刷新session 
				//$role = Db::name('Role')->where("id", $admin['id'])->find();
				//session('role', $role);  //刷新权限

				$this->admin = $admin;
				$this->admin_id = $admin['id'];
				$this->assign('admin', $admin); //存储用户信息
				$this->assign('admin_id', $this->admin_id);
			}
			else
			{
				// 免登录动作列表
				$nologin = array(
					'login', 'dologin', 'logout',
				);
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Admin/Index/login');
					exit;
				}
			}
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
			$admin = Db::name('Admin')->where($map)->find();

			//登录成功
			if ($admin)
			{
				// 存储session
				session('admin', $admin);
				$this->success('登录成功', 'index');
			}
			else
			{
				$this->error('账号或密码错误', 'login');
			}
		}

		// 退出登录
		public function logout()
		{
			// 用户信息
			session('admin', null);
			// 角色权限
			session('role', null);

			// 经纬度存在cookie中保留
			$this->success('退出完毕', 'index');
		}

		// 首页
		public function index()
		{
			$menu = getMenuArr2();
			$request = Request::instance();

			$this->assign('module', $request->module());
			$this->assign('menu', $menu);
			return $this->fetch();
		}

	}
	