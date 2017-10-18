<?php
	return [
		'template' => [
			'view_path' => APP_PATH . '../template/admin/',
		],
		// 提示模板
		'dispatch_success_tmpl' => 'Public:dispatch_jump',
		'dispatch_error_tmpl' => 'Public:dispatch_jump',
		// 404 和 500
		'http_exception_template' => [
			404 => 'Public:404',
			500 => 'Public:500',
		],
	];
	