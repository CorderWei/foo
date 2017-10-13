<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Goods extends Controller
	{

		public function goods_list()
		{
			return $this->fetch();
		}
		public function buy()
		{
			return $this->fetch();
		}
		
	}
	