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
		}

		public function index()
		{
			// 当前基础认证模型
			$baseid = $this->request->param('cat_id');
			$basemodel = Db::name('Basemodel')->find($baseid);
			// 备用
			session('basemodel',$basemodel);
			
			// 系统所有业务分类
			$categorys = Db::name('category')->select();
			$this->assign('categorys', $categorys);
			return $this->fetch();
		}
		
		// 模型分类认证
		public function auth()
		{
			// 要认证的分类
			var_dump(input('cat_id'));
			// 获取绑定的所有分类
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);
			return $this->fetch();
		}
		
		public function detail()
		{
			$cat_id = $this->request->param('cat_id');
			if(is_authed($cat_id)){
				return $this->fetch();
			}else{
				return $this->error('您尚未认证所需信息', "auth?cat_id={$cat_id}");
			}
			
		}

	}
	