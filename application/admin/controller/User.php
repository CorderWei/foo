<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class User extends Base
	{

		public function _initialize()
		{
			// 免登录动作列表
			$this->nologin = array();
			parent::_initialize();
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

			// 根据模型查询不同的 联合表的数据
			switch ($base_id)
			{
				case 1:
					$pagedata = Db::table("foo_$table_name")
						->alias('t')
						->join('foo_category c', 'c.id = t.cat_id', 'LEFT')
						->join('foo_user u', 'u.id = t.user_id', 'LEFT')
						->field("t.*,c.name cat_name,u.name user_name")
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;
				case 2:
					$pagedata = Db::table("foo_$table_name")
						->alias('t')
						->join('market_cat c', 'c.id = t.mc_id', 'LEFT')
						->join('foo_user u', 'u.id = t.user_id', 'LEFT')
						->field("t.*,t.mc_id cat_id,c.name cat_name,u.name user_name")
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;

				default:
					$pagedata = Db::table("foo_$table_name")
						->alias('t')
						->join('market_cat c', 'c.id = t.cat_id', 'LEFT')
						->join('foo_user u', 'u.id = t.user_id', 'LEFT')
						->field("t.*,c.name cat_name,u.name user_name")
						->paginate(10, false, [
						'query' => Request::instance()->param(),
					]);
					break;
			}

//			$pagedata = Db::table("foo_$table_name")
//				->alias('t')
//				->join('foo_category c', 'c.id = t.cat_id', 'LEFT')
//				->join('foo_user u', 'u.id = t.user_id', 'LEFT')
//				->field("t.*,c.name cat_name,u.name user_name")
//				->paginate(10, false, [
//				'query' => Request::instance()->param(),
//			]);
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
					$auth_code = $model_id . "_" . $cat_id;
					// 更新 user 表中对应数据的cat_ids字段
					$new_auth = change_auth($auth_code, $old_auth);
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
	