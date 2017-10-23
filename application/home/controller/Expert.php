<?php

	namespace app\home\controller;

	use app\home\controller\Base;
	use think\Request;
	use think\Db;

	/**
	 * Description of Market
	 *
	 * @author Administrator
	 */
	class Expert extends Base
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

		public function my_course()
		{
			$uid = $this->user_id;
			$list = Db::name('course')->where("user_id = $uid")->paginate(10);
			$this->assign("list", $list);
			$this->assign('paginate', $list->render());
			return $this->fetch();
		}

		public function course_list()
		{
			$list = Db::name('course')->where("is_publish = 1")->paginate(10);
			$this->assign("list", $list);
			$this->assign('paginate', $list->render());
			return $this->fetch();
		}

		public function add_course()
		{
			$this->authCheck();
			if (Request::instance()->isPost())
			{
				$map = Request::instance()->param();
				$map['pro'] = session('position.pro_id');
				$map['city'] = session('position.city_id');
				$map['area'] = session('position.area_id');
				$map['add_time'] = time();
				// 图片上传
				$pic_array = ['thumb']; // 设定允许上传的字段
				$files = $this->request->file();
				foreach ($files as $key => $value)
				{
					if (in_array($key, $pic_array))
					{
						// 存储路径
						$path = '/uploads' . DS . "$key";
						// 执行存储
						$save = $value->
							validate(['size' => 2097152, 'ext' => 'jpg,png,gif'])->
							move(ROOT_PATH . 'public' . $path);
						if ($save)
						{
							// 组装路径用于写入数据库
							$map[$key] = $path . DS . $save->getSaveName();
						}
						else
						{
							return $save->getError();
						}
					}
				}
				if (Db::name('course')->insert($map))
				{
					$this->success('发布成功，请等待审核', url('Expert/index'));
				}
				else
				{
					$this->error('发布成功，请联系管理', url('Expert/index'));
				}
			}
			return $this->fetch();
		}

		public function detail()
		{
			$course_id = Request::instance()->param("id");
			$course = Db::name('Course')->find($course_id);
			$this->assign('course', $course);
			return $this->fetch();
		}

	}
	