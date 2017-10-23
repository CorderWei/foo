<?php

	namespace app\home\controller;

	use think\Request;
	use think\Db;
	use app\home\controller\Base;

	class Auth extends Base
	{

		public function _initialize()
		{
			parent::_initialize();
		}

		// 准备认证所需要的数据项和模板
		public function auth_tpl()
		{
			//
			$basemodel = session('basemodel');
			$model_id = $basemodel['id'];
			$table_name = $basemodel['table_name'];
			$cat_id = Request::instance()->param('cat_id');
			$mc_id = Request::instance()->param('mc_id');
			switch ($model_id)
			{

				case 1:
					// 养殖户的具体分类,确定select框的value和name以及当前选中项
					$cats = Db::name('category')->where('pid = 0')->select();
					$this->assign('cats', $cats);
					$this->assign('auth_catid', $cat_id);
					break;
				case 2:
					// 厂商户的具体分类,确定select框的value和name以及当前选中项
					$cats = Db::name('market_cat')->where('pid = 0')->select();
					$this->assign('cats', $cats);
					$this->assign('auth_catid', $mc_id);
					break;
				case 3:

					break;
				case 4:

					break;

				default:
					break;
			}
			return $this->fetch();
		}

		// 模型分类认证
		public function doauth()
		{
			// 正在认证时,如无权限则继续执行
			$this->authCheck(true);
			// 根据认证分类确定模型
			$model_id = $this->model_id;
			$post_data = $this->request->param();
			// 公共信息
			$map['user_id'] = $post_data['user_id']; //用户id
			$map['name'] = $post_data['name']; //姓名
			$map['phone'] = $post_data['phone']; //电话
			$map['address'] = $post_data['address']; //地址
			$map['pro'] = $post_data['pro']; //省
			$map['city'] = $post_data['city']; //市
			$map['area'] = $post_data['area']; //区
			$map['card_no'] = $post_data['card_no']; //身份证
			$map['intro'] = $post_data['intro']; //简介
			// 默认未通过审核
			$map['is_auth'] = 0;

			switch ($model_id)
			{
				//饲养户
				case 1:
					// 业务方向,容量信息
					$map['cat_id'] = $post_data['cat_id'];
					$map['capacity'] = $post_data['capacity'];
					break;
				//厂区拥有者
				case 2:
					// 厂区分类
					$map['mc_id'] = $post_data['mc_id'];
					$map['license'] = $post_data['license']; //资质证件-营业执照
					break;
				//专家
				case 3:
					$map['school_name'] = $post_data['school_name']; //毕业学校
					$map['school_address'] = $post_data['school_address']; //学校地址
					$map['license'] = $post_data['license']; //资质证件-专家证书
					break;
				// 运输车
				case 4:
					$map['car_no'] = $post_data['car_no'];  //车号
					$map['radius'] = $post_data['radius'];  //配送半径
					$map['car_license'] = $post_data['car_license']; //驾照
					break;
				default:
					break;
			}

			// 图片上传部分
			$pic_array = ['owner_pic', 'market_pic', 'car_pic']; // 设定允许上传的字段
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
			// 表名
			$table_name = Db::name('Basemodel')->where('id', $model_id)->value('table_name');
			if (Db::name($table_name)->insert($map))
			{
				$this->success('申请成功，请等待审核');
			}
			else
			{
				$this->error('申请失败，请联系管理');
			}
			//return $this->fetch();
		}

		// 我的认证
		public function my_auth()
		{
			$user = $this->user;
			$cat_ids = explode(',', $user['cat_ids']);
			foreach ($cat_ids as $key => $value)
			{
				$mid = substr($value, 0, 1);
				switch ($mid)
				{
					case 1:
						$name_arr[] = "养殖用户";
						break;
					case 2:
						$name_arr[] = "厂商用户";
						break;
					case 3:
						$name_arr[] = "专家用户";
						break;
					case 4:
						$name_arr[] = "物流用户";
						break;

					default:
						break;
				}
			}
			$user['auth_names'] = implode(", ", array_unique($name_arr));
			$this->assign('user', $user);
			return $this->fetch();
		}

	}
	