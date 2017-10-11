<?php

	namespace app\home\model;

	use think\Model;

	/**
	 * Description of Article
	 *
	 * @author Administrator
	 */
	class Article extends Model
	{

		protected $type = [
			'add_time' => 'timestamp:Y-m-d',
			'edit_time' => 'timestamp:Y-m-d'
		];

	}
	