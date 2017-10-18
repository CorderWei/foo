<?php

	return array(
		array('name' => '设置', 'child' => array(
				array('name' => '站点设置', 'act' => 'index', 'op' => 'System'),
				array('name' => '清除缓存', 'act' => 'cleanCache', 'op' => 'System'),
			)),
		array('name' => '会员', 'child' => array(
				array('name' => '会员分类', 'act' => 'index', 'op' => 'User'),
				array('name' => '会员列表', 'act' => 'index', 'op' => 'User'),
				array('name' => '认证申请', 'act' => 'auth_cate', 'op' => 'User'),
			)),
		array('name' => '文章', 'child' => array(
				array('name' => '文章列表', 'act' => 'articleList', 'op' => 'Article'),
				array('name' => '文章分类', 'act' => 'categoryList', 'op' => 'Article'),
				array('name' => '公告管理', 'act' => 'notice_list', 'op' => 'Article'),
				array('name' => '专题列表', 'act' => 'topicList', 'op' => 'Topic'),
			)),
		array('name' => '权限', 'child' => array(
				array('name' => '管理员列表', 'act' => 'index', 'op' => 'Admin'),
				array('name' => '角色管理', 'act' => 'role', 'op' => 'Admin'),
				array('name' => '权限列表', 'act' => 'right_list', 'op' => 'System'),
				array('name' => '管理员日志', 'act' => 'log', 'op' => 'Admin'),
			)),
		array('name' => '商品', 'child' => array(
				array('name' => '商品分类', 'act' => 'categoryList', 'op' => 'Goods'),
				array('name' => '商品列表', 'act' => 'goodsList', 'op' => 'Goods'),
				array('name' => '商品模型', 'act' => 'goodsTypeList', 'op' => 'Goods'),
				array('name' => '商品规格', 'act' => 'specList', 'op' => 'Goods'),
				array('name' => '品牌列表', 'act' => 'brandList', 'op' => 'Goods'),
			)),
		array('name' => '订单', 'child' => array(
				array('name' => '订单列表', 'act' => 'index', 'op' => 'Order'),
				//		array('name' => '发货单', 'act'=>'delivery_list', 'op'=>'Order'),
				//		array('name' => '退货单', 'act'=>'return_list', 'op'=>'Order'),
				//		array('name' => '添加订单', 'act'=>'add_order', 'op'=>'Order'),
				array('name' => '订单日志', 'act' => 'order_log', 'op' => 'Order'),
			)),
		array('name' => '统计', 'child' => array(
				array('name' => '养殖概况', 'act' => 'index', 'op' => 'Report'),
				array('name' => '销售概况', 'act' => 'index', 'op' => 'Report'),
				array('name' => '销售排行', 'act' => 'saleTop', 'op' => 'Report'),
				array('name' => '销售明细', 'act' => 'saleList', 'op' => 'Report'),
				array('name' => '会员统计', 'act' => 'user', 'op' => 'Report'),
			//		array('name' => '运营概览', 'act'=>'finance', 'op'=>'Report'),
			)),
	);
	