<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	/**
	 * Description of Base
	 *
	 * @author Administrator
	 */
	class Base extends Controller
	{

		// 当前控制器下免登录action
		public $nologin = [];

		public function _initialize()
		{
			parent::_initialize();
			// 定位检查
			$this->needPosition();
			// 登录检查和更新用户状态
			$this->needLogin($this->nologin);
		}

		public function needPosition()
		{
			// 位置信息 session空则找cookie,都空则跳转到定位
			if (!session('?position'))
			{
				if (cookie('?position'))
				{
					session('position', cookie('position'));
				}
				else
				{
					$this->redirect('Index/citychange');
				}
			}
			$cur_city = session('position.city_name');
			$this->assign('cur_city', $cur_city);
		}

		//
		public function needLogin($nologin)
		{
			// 用户登录
			if (session('?user'))
			{
				$user = session('user');
				$coord = GetCoord();
				$map['is_online'] = 1;
				$map['lon'] = $coord['x'];
				$map['lat'] = $coord['y'];
				// 更新用户在线状态和坐标位置
				Db::name('User')->where("id", $user['id'])->update($map);
				$user = Db::name('User')->where("id", $user['id'])->find();
				session('user', $user);  //覆盖session 中的 user               
				$this->user = $user;
				$this->user_id = $user['id'];
				$this->assign('user', $user); //存储用户信息
				$this->assign('user_id', $this->user_id);
			}
			else
			{
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Home/Index/login');
					exit;
				}
			}
		}

	}
	