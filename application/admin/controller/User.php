<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class User extends Controller
	{

		public function _initialize()
		{
			parent::_initialize();
			if (session('?admin'))
			{
				$admin = session('admin');
				$admin = Db::name('Admin')->where("id", $admin['id'])->find();
				session('admin', $admin);  //刷新session 
				//$role = Db::name('Role')->where("id", $admin['id'])->find();
				//session('role', $role);  //刷新权限

				$this->admin = $admin;
				$this->admin_id = $admin['id'];
				$this->assign('admin', $admin); //存储用户信息
				$this->assign('admin_id', $this->admin_id);
			}
			else
			{
				// 免登录动作列表
				$nologin = array(
				);
				if (!in_array($this->request->action(), $nologin))
				{
					$this->error('请您先登录！', 'Admin/Index/login');
					exit;
				}
			}
		}

		// 验证用户分类
		public function auth_cate()
		{
			$list = Db::name('Basemodel')->limit(4)->select();
			$this->assign("list", $list);
			echo $this->fetch();
		}

		// 验证信息列表
		public function auth_list()
		{
			$base_id = Request::instance()->param('base_id');
			$table_name = Request::instance()->param('table_name');
			$model_name = Request::instance()->param('model_name');
			$this->assign("base_id", $base_id);
			$this->assign("model_name", $model_name);
			$this->assign("table_name", $table_name);

			$pagedata = Db::table("foo_$table_name")
				->alias('t')
				->join('foo_category c', 'c.id = t.cat_id', 'LEFT')
				->join('foo_user u', 'u.id = t.user_id', 'LEFT')
				->field("t.*,c.name cat_name,u.name user_name")
				->paginate(10);
			//$pagedata = Db::name($table_name)->paginate(10);
			$this->assign("pagedata", $pagedata);
			echo $this->fetch();
		}

		// 执行用户认证,更改对应表格中认证信息的状态,更改用户表中的权限合计
		public function user_auth()
		{
			$param = Request::instance()->param();
			if (sizeof($param) == extract($param))
			{
				// 启动事务
				Db::startTrans();
				try
				{
					// 更新 feeder,market,expert,transport 表中对应数据的is_auth字段
					Db::name($table)->where($kn, $kv)->setField($fn, $fv);
					// 查找用户在user表中的权限码
					$uid = Db::name($table)->where($kn, $kv)->value('user_id');
					$old_auth = Db::name('user')->where("id = $uid")->value('cat_ids');
					// 根据模型和业务方向拼接的权限码,全部业务则cat_id为0
	                $auth_code = $model_id."_".$cat_id;
					// 更新 user 表中对应数据的cat_ids字段
					$new_auth = change_auth($auth_code,$old_auth);
					Db::name('user')->where("id = $uid")->setField('cat_ids', $new_auth);
					// 提交事务
					Db::commit();
					return [
						"is_done" => 1,
						"message" => '更新成功!'
					];
				}
				catch (\Exception $e)
				{
					// 回滚事务
					Db::rollback();
					return [
						"is_done" => 0,
						"message" => '更新失败!'
					];
				}
			}
			else
			{
				
			}
		}

	}
	