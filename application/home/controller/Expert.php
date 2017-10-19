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
	class Expert extends Controller
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

		public function course_list()
		{
			$this->check_auth();
			$uid = $this->user_id;
			$list = Db::name('course')->where("user_id = $uid")->paginate(10);
			$this->assign("list", $list);
			return $this->fetch();
		}

		public function add_course()
		{
			$this->check_auth();
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
					$this->success('发布成功，请等待审核', url('category/index', ['model_id' => 3]));
				}
				else
				{
					$this->error('发布成功，请联系管理', url('category/index', ['model_id' => 3]));
				}
			}
			return $this->fetch();
		}
		public function detail(){
			$course_id = Request::instance()->param("id");
			$course = Db::name('Course')->find($course_id);
			$this->assign('course',$course);
			return $this->fetch();
		}
		
		// 权限验证,能否查看和发布文章
		public function check_auth()
		{
			// 更新当前基础模型编码
			$model_id = Request::instance()->param('model_id');
			$basemodel = Db::name('Basemodel')->find($model_id);
			session('basemodel', $basemodel);
			// 2,3,4 基础模型依赖模型ID传输数据
			$this->assign('model_id', $model_id);

			if (is_authed(0))
			{
				
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
					return $this->error('您尚未认证所需信息', Url('category/auth', ['model_id' => $model_id]));
				}
			}
		}

	}
	