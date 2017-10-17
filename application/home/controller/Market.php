<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	/**
	 * Description of Market
	 *
	 * @author Administrator
	 */
	class Market extends Controller
	{

		public function _initialize()
		{
			parent::_initialize();
			if (session('?user'))
			{
				$user = session('user');
				$user = Db::name('User')->where("id", $user['id'])->find();
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
					$this->error('请您先登录！', 'Home/Index/login');
					exit;
				}
			}
			// 获取用户所选(所在)当前城市名称
			$cur_city = GetCurrentCityName();
			$this->assign('cur_city', $cur_city);
		}

		public function detail()
		{
			// 更新当前基础模型编码
			$model_id = Request::instance()->param('model_id');
			$basemodel = Db::name('Basemodel')->find($model_id);
			session('basemodel',$basemodel);
			// 2,3,4 基础模型依赖模型ID传输数据
			$this->assign('model_id', $model_id);

			if (is_authed(0))
			{
				return $this->fetch();
			}
			else
			{
				$model_name = session('basemodel.table_name');
				$uid = $this->user_id;
				$map['model_id'] = $model_id;
				$map['user_id'] = $uid;
				$map['is_auth'] = 0;
				if (Db::name($model_name)->where($map)->find())
				{
					return $this->error('您的信息正在认证中,请耐心等待');
				}
				else
				{
					return $this->error('您尚未认证所需信息', Url('category/auth',['model_id'=> $model_id]));
				}
			}
			
			return $this->fetch();
		}

	}
	