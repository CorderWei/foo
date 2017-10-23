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

		public function index()
		{
			return $this->fetch();
		}

		public function my_car()
		{
			$this->authCheck();
			$uid = $this->user_id;
			$car = Db::name('Transport')->where('user_id', $uid)->find();
			$this->assign('car', $car);
			return $this->fetch();
		}

		public function car_list()
		{
			if (Request::instance()->isPost())
			{
				// 省份
				$map = array_filter(input());
				// 半径特殊处理
				if(isset($map['radius'])){
					$map['radius'] = ['<',$map['radius']];
				}
				$map['is_auth'] = 1;
				$cars = Db::name('Transport')->where($map)->paginate(10, false, [
					'query' => Request::instance()->param(),
				]);
				$this->assign('list', $cars);
				$this->assign('paginate', $cars->render());
				echo $this->fetch('_car_list');
			}
			else
			{
				$map['is_auth'] = 1;
				$cars = Db::name('Transport')->where($map)->paginate(10, false, [
					'query' => Request::instance()->param(),
				]);
				$this->assign('list', $cars);
				$this->assign('paginate', $cars->render());
				return $this->fetch('car_list');
			}
		}

		public function car_manage()
		{
			return $this->fetch();
		}

	}
	