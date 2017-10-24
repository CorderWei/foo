<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"E:\WWW\foo\public/../application/../template/admin/system\config.html";i:1508814500;s:67:"E:\WWW\foo\public/../application/../template/admin/public\head.html";i:1508816494;s:67:"E:\WWW\foo\public/../application/../template/admin/public\foot.html";i:1507517183;}*/ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8" />
		<title>养殖天网管理中心</title>
		<meta name="description" content="description" />
		<meta name="author" content="wxl" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="" />
		<!--[if lt IE 9]>
	<script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
		<link rel="shortcut icon" href="" />
		<!-- ios/android书签图标-->
		<meta name="mobile-web-app-capable" content="yes" />
		<link rel="icon" sizes="196x196" href="" />
		<link rel="apple-touch-icon" sizes="152x152" href="" />
		<!-- css -->
		<link rel="stylesheet" type="text/css" href="/assets/style/normalize.css" /> 
		<link rel="stylesheet" type="text/css" href="/assets/style/predefine.css" /> 
		<link rel="stylesheet" type="text/css" href="/assets/style/style.css" />
		<link rel="stylesheet" type="text/css" href="/assets/style/admin.css" />
		<!-- js -->
		<script type="text/javascript" src="/assets/script/prefixfree.min.js"></script> 
		<script type="text/javascript" src="/assets/script/jquery-1.12.4.min.js"></script> 
		<script type="text/javascript" src="/assets/layer/layer.js"></script> 
		<script type="text/javascript" src="/assets/script/foo-js-0.5.js"></script> 
		<script>
			$(function () {
				console.log(123);
			});
		</script>
	</head>

<body>
	<form id="config_form" data-url="">
		<ul class="simple-ul">
			<li>
				<label>站点名称:</label>
				<input value="养殖天网"/>
			</li>
			<li>
				<label>联系电话:</label>
				<input value="3442222"/>
			</li>
			<li>
				<label>电子邮箱:</label>
				<input value="tianwang@126.com"/>
			</li>
			<li>
				<label>地址:</label>
				<input value="山东济南"/>
			</li>
			<li>
				<label></label>
				<span class="foo_submit">提交</span>
			</li>
		</ul>	
	</form>	
</body>
<script>
	
	foo.trans.ajaxForm("#config_form",true,function(){
		
	});
</script>
</html>

