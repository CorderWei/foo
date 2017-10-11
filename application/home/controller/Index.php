<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;
	use think\Loader;
	use app\home\model\User;
	use app\home\model\Article;

	class Index extends Controller
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
					'login', 'dologin', 'logout', 'register', 'doregister', 'changepass', 'index', 'note_city',
					'citychange',
				);
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Home/Index/login');
					exit;
				}
			}
		}

		public function index()
		{
			// 获取坐标位置
			// $coord = GetCoord();
			// 获取用户所选(所在)当前城市名称
			$cur_city = GetCurrentCityName();
			$this->assign('cur_city', $cur_city);

			// 轮播
			// 入口分类
			$cats = Db::name('category')->where('pid = 0')->select();
			$this->assign('cats', $cats);
			// 文章
			$article = new Article;
			
			if(session('?position')){
				
			}
			$arts = $article->limit(6)->select();
			$this->assign('arts', $arts);
			return $this->fetch();
		}
		// 文章详情
		public function article_detail(){
			$id = $this->request->param('id');
			$article = Article::get($id);
			$this->assign('article', $article);
			return $this->fetch();
		}

		// 登录
		public function login()
		{
			return $this->fetch();
		}

		// 执行登录
		public function dologin()
		{
			$data = input();
			$map['name'] = $data['name'];
			$map['pass'] = MD5(MD5($data['pass']));
			$user = Db::name('User')->where($map)->find();

			//登录成功
			if ($user)
			{
				// 存储session
				session('user', $user);
				$this->success('登录成功', 'index');
			}
			else
			{
				$this->error('账号或密码错误', 'login');
			}
		}

		// 注册
		public function register()
		{
			return $this->fetch();
		}

		// 执行注册
		public function doregister()
		{
			$requset = Request::instance();
			$data = $requset->param();
			// 采用验证器验证
			$validate = Loader::validate('Index');
			if (!$validate->check($data))
			{
				$this->error($validate->getError());
			}
			// 新增用户
			$user = new User;
			$user->data([
				'name' => $data['name'],
				'pass' => MD5(MD5($data['pass'])),
				'add_time' => time(),
			]);
			//注册成功后直接登录
			if ($user->save())
			{
				$new_user = Db::name('User')->where("id", $user->id)->find();
				session('user', $new_user);
				$this->success('注册成功', 'index');
			}
			else
			{
				$this->redirect('register');
			}
		}

		// 密码修改
		public function changepass()
		{
			// 更改
			if ($this->request->isPost())
			{
				$data = input();
				$user = $this->user;
				$u_id = $this->user_id;
				$map['name'] = $user['name'];
				$map['pass'] = MD5(MD5($data['old']));
				$u = Db::name('User')->where($map)->find();
				if ($u)
				{
					if ($data['xin'] == $data['que'])
					{
						$d['pass'] = MD5(MD5($data['xin']));
						Db::name('User')->where("id = $u_id")->update($d);
						$this->success('密码修改成功,请牢记新密码');
					}
				}
				else
				{
					$this->error('原始密码错误');
				}
			}
			// 展示
			else
			{
				return $this->fetch();
			}
		}

		// 退出登录
		public function logout()
		{
			// 用户信息
			session('user', null);
			// 位置信息
			session('position', null);
			// 经纬度存在cookie中保留
			$this->success('退出完毕', 'index');
		}

		// 城市切换
		public function citychange()
		{
			if (request()->isPost())
			{
				$parent_id['parent_id'] = input('post.pro_id', 'addslashes');
				$region = Db::name('Region')->where($parent_id)->select();
				$opt = '<option value=0>--请选择市区--</option>';
				foreach ($region as $key => $val)
				{
					$opt .= "<option value='{$val['region_id']}'>{$val['region_name']}</option>";
				}
				echo json_encode($opt);
			}
			else
			{
				$parent_id['parent_id'] = 1;
				$region = Db::name('Region')->where($parent_id)->select();
				$this->assign('region', $region);
				return $this->fetch();
			}
		}

		// 当前位置信息存入session
		public function note_city()
		{
			$data = input('post.');
			session('position', $data);
			echo 1;
		}

		// 环信入口
		public function huanxin()
		{
			return $this->fetch();
		}

	}
	