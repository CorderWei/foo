<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Index extends Base
	{

		public function _initialize()
		{
			$this->nologin = array(
				'login', 'dologin', 'logout',
			);
			parent::_initialize();
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
	