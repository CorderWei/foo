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
			$this->authCheck();
		}
		
		public function index(){
			return $this->fetch();
		}
		public function my_car(){
			$uid = $this->user_id;
			$car = Db::name('Transport')->where('user_id',$uid)->find();
			$this->assign('car', $car);
			return $this->fetch();
		}
		public function car_list(){
			return $this->fetch();
		}
		
		public function car_manage(){
			return $this->fetch();
		}

	}
	