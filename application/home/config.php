<?php

	return [
		// 默认模板位置
		'template' => [
			'view_path' => APP_PATH . '../template/pc/',
		],
		// 提示模板
		'dispatch_success_tmpl' => 'Public:dispatch_jump',
		'dispatch_error_tmpl' => 'Public:dispatch_jump',
		// 404 和 500
		'http_exception_template' => [
			404 => 'Public:404',
			500 => 'Public:500',
		],
		// 视图输出字符串内容替换
//		'view_replace_str' => [
//			'_CSS_' => '/public/assets/style',
//			'_JS_' => '/public/assets/script'
//		],
	];
	