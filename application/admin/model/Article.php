<?php
	namespace app\admin\model;
	use think\Model;
	/**
	 * Description of Article
	 *
	 * @author Administrator
	 */
	class Article extends Model
	{
		protected $insert = ['add_time'];
		protected $update = ['edit_time'];
		
		protected function setAddTimeAttr(){
			return time();
		}
		protected function setEditTimeAttr(){
			return time();
		}
	}
	