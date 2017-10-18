<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class User extends Controller
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
					
				);
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Admin/Index/login');
					exit;
				}
			}
		}
		
		public function auth_cate(){
			$list = Db::name('Basemodel')->limit(4)->select();
			$this->assign("list", $list);
			echo $this->fetch();
		}
		
		public function auth_list(){
			//$list = Db::name('')->
			echo $this->fetch();
		}
	}
	