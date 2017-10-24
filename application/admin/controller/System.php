<?php

	namespace app\admin\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class System extends Base
	{

		public function _initialize()
		{
			$this->nologin = array(
			);
			parent::_initialize();
		}

		// 站点设置
		public function config()
		{
			echo $this->fetch();
		}
		
		public function cleanCache(){
			$result = \think\Cache::clear();
			if($result){
				echo js_msg("缓存清理完毕",1);
			}else{
				echo js_msg("系统繁忙,请稍后重试",2);
			}	
		}
	}
					