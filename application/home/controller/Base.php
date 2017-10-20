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
			// 获取基础模型信息
			$this->getBaseModel();
			if (session('?basemodel'))
			{
				$this->model_id = session('basemodel.id');
			}
			// 城市选择组件所需数据
			$parent_id['parent_id'] = 1;
			$region = Db::name('Region')->where($parent_id)->select();
			$this->assign('region', $region);
		}

		// 位置锁定
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

		// 用户登录
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

		// 模型定位
		public function getBaseModel()
		{
			
			$this->model_id = Request::instance()->param('model_id') ?: session('basemodel.id');
			
			if (!empty($this->model_id))
			{
				$basemodel = Db::name('basemodel')->find($this->model_id);
				if ($basemodel)
				{
					session('basemodel', $basemodel);
				}
			}
		}

		// 根据权限判定能否进入该区域
		public function authCheck()
		{
			$basemodel = session('basemodel');
			$model_id = $basemodel['id'];
			$cat_id = Request::instance()->param('cat_id');
			$mc_id = Request::instance()->param('mc_id');
			$table_name = $basemodel['table_name'];
			$where['user_id'] = $this->user_id;
			$where['is_auth'] = 0;
			switch ($model_id)
			{
				case 1:
					$cid = $cat_id ?: 0;
					$where['cat_id'] = $cid;
					break;
				case 2:
					$cid = $mc_id ?: 0;
					$where['mc_id'] = $cid;
					break;
				case 3:
					$cid = 0;
					break;
				case 4:
					$cid = 0;
					break;

				default:
					break;
			}
			Db::name($table_name)->where($where)->select();
			if (!is_authed($cid))
			{
				if (Db::name($table_name)->where($where)->select())
				{
					return $this->error('您的信息正在认证中,请耐心等待');
				}
				else
				{
					return $this->error('您尚未认证所需信息', "auth?cat_id={$cat_id}");
				}
			}
		}

	}
	