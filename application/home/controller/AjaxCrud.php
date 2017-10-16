<?php

	namespace app\home\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class AjaxCrud extends Controller
	{

		// 通用 CRUD
		public function handle()
		{
			if (Request::instance()->isAjax())
			{
				$param = Request::instance()->param();
				if (sizeof($param) == extract($param))
				{
					switch ($handle)
					{
						case 'C':

							break;
						case 'R':

							break;
						case 'U':
							if (Db::name($table)->where($kn, $kv)->setField($fn, $fv))
							{
								return [
								"is_done" => 1,
								"message" => '更新成功!'
								];
							}
							else
							{
								return [
								"is_done" => 0,
								"message" => '更新失败!'
								];
							}
							break;
						case 'D':
							if (Db::name($table)->where($kn,$kv)->delete())
							{
								return [
								"is_done" => 1,
								"message" => '删除成功!'
								];
							}
							else
							{
								return [
								"is_done" => 0,
								"message" => '删除失败!'
								];
							}
							break;
						default:
							break;
					}
				}
				else
				{
					
				}
			}
		}

	}
	