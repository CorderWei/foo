<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Base extends Controller
	{

		// 当前控制器下免登录action
		public $nologin = [];

		public function _initialize()
		{
			parent::_initialize();
			// 登录检查和更新用户状态
			$this->needLogin($this->nologin);
		}

		// 用户登录
		public function needLogin($nologin)
		{
			// 用户登录
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
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Admin/Index/login');
					exit;
				}
			}
		}

	}
	