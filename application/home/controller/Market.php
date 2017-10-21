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
	class Market extends Base
	{

		public function _initialize()
		{
			parent::_initialize();
		}
		
		public function index(){
			$market_cats = Db::name('market_cat')->where('pid = 0')->select();
			$this->assign('market_cats', $market_cats);
			return $this->fetch();
		}

		public function detail()
		{
			$this->authCheck();
			return $this->fetch();
		}

	}
	