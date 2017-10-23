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

		public function index()
		{
			$market_cats = Db::name('market_cat')->where('pid = 0')->select();
			$this->assign('market_cats', $market_cats);
			return $this->fetch();
		}

		public function detail()
		{
			$this->authCheck();
			$mc_id = Request::instance()->param('mc_id');
			$this->assign('mc_id', $mc_id);
			// 厂商分类名称
			$soncat_name = Db::name('Market_cat')->where("id = $mc_id")->value('name');
			$this->assign("soncat_name", $soncat_name);
			return $this->fetch();
		}

		// 已经注册和审核的厂商列表
		public function market_list()
		{

			if (Request::instance()->isPost())
			{
				$where = array_filter(Request::instance()->param());
				$where['is_auth'] = 1;
				$list = Db::name('Market')->where($where)->paginate(10, false, [
					'query' => Request::instance()->param(),
				]);
				// 渲染mc_id用户ajax
				$this->assign("mc_id", $where['mc_id']);
				$this->assign("list", $list);
				$this->assign('paginate', $list->render());
				echo $this->fetch('_market_list');
			}
			else
			{
				//$where['city'] = session('position.city_id');
				$where['mc_id'] = Request::instance()->param('mc_id');
				$where['is_auth'] = 1;
				$list = Db::name('Market')->where($where)->paginate(10, false, [
					'query' => Request::instance()->param(),
				]);
				// 渲染mc_id用户ajax
				$this->assign("mc_id", $where['mc_id']);
				$this->assign("list", $list);
				$this->assign('paginate', $list->render());
				return $this->fetch();
			}
		}

	}
	