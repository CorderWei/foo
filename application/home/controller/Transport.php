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
	class Transport extends Base
	{

		public function _initialize()
		{
			parent::_initialize();
		}
		
		public function index(){
			return $this->fetch();
		}
		public function my_car(){
			$this->check_auth();
			$uid = $this->user_id;
			$car = Db::name('Transport')->where('user_id',$uid)->find();
			$this->assign('car', $car);
			return $this->fetch();
		}
		public function car_list(){
			$this->check_auth();
			return $this->fetch();
		}
		
		public function car_manage(){
			$this->check_auth();
			return $this->fetch();
		}

		// 权限验证
		public function check_auth()
		{
			// 更新当前基础模型编码
			$model_id = session('basemodel.id');
			// 2,3,4 基础模型依赖模型ID传输数据
			$this->assign('model_id', $model_id);

			if (is_authed(0))
			{
				
			}
			else
			{
				$table_name = session('basemodel.table_name');
				$uid = $this->user_id;
				$map['model_id'] = $model_id;
				$map['user_id'] = $uid;
				$map['is_auth'] = 0;
				if (Db::name($table_name)->where($map)->find())
				{
					return $this->error('您的信息正在认证中,请耐心等待');
				}
				else
				{
					return $this->error('您尚未认证所需信息', Url('category/auth', ['model_id' => $model_id]));
				}
			}
		}

	}
	