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
					$this->assign('auth_catid', $cat_id);
					break;
				case 3:

					break;
				case 4:

					break;

				default:
					break;
			}
//			$this->assign('auth_catid', $cat_id);
//			$this->assign('auth_catid', $mc_id);
//			$this->assign('cats', $cats);
			// 要认证的分类
//			$auth_catid = input('cat_id');
//			$auth_mcid = input('mc_id');
//			if (empty($auth_catid))
//			{
//				$auth_catid = 0;
//			}
//			$this->assign('auth_catid', $auth_catid);
//
//			// 获取绑定的所有分类
//			$cats = Db::name('category')->where('pid = 0')->select();
			

			// 根据基础认证模型确定要填写的表单 1为饲养户，2为厂区，3为专家，4为运输
			return $this->fetch();
		}
		
		// 模型分类认证
		public function doauth()
		{
			if(authCheck){
				$this->error('您已经认证过该信息,请勿重复认证');
			}
			// 根据认证分类确定模型
			$model_id = $this->request->param('model_id');
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
				//厂区拥有者, 暂不用父级分支, 跳入5,6
				case 2:

					break;
				//专家
				case 3:
					$map['school_name'] = $post_data['school_name'];
					$map['school_address'] = $post_data['school_address'];
					$map['license'] = $post_data['license'];
					break;
				// 运输车
				case 4:
					$map['car_no'] = $post_data['car_no'];
					$map['radius'] = $post_data['radius'];
					$map['car_license'] = $post_data['car_license'];
					break;
				case 5:
				case 6:
					// 营业执照编号，子模型编号(兽药，饲料)
					$map['model_id'] = $model_id;
					$map['license'] = $post_data['license'];
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
				$this->success('申请成功，请等待审核', url('index', ['model_id' => $model_id]));
			}
			else
			{
				$this->error('申请失败，请联系管理', url('index', ['model_id' => $model_id]));
			}
			//return $this->fetch();
		}

	}
	