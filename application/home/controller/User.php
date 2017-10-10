<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class User extends Controller
	{

		public function index()
		{
			return $this->fetch();
		}

		// 身份认证
		public function auth()
		{
			// 获取绑定的所有分类
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);
		}

	}
	