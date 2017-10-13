<?php

	namespace app\home\model;

	use think\Model;

	class Goods extends Model
	{

		// 字段展示时自动转换类型
		protected $type = [
			'add_time' => 'timestamp:Y-m-d',
		];
		// 要自动完成的属性集合,存入/更新时自动调用对应修改器
		protected $auto = [
			'add_time',
		];

		// 修改器
		public function setAddTimeAttr()
		{
			return time();
		}

	}
	