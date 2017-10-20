<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"E:\WWW\foo\public/../application/../template/pc/index\register.html";i:1507882480;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8" />
		<title>养殖天网系统</title>
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
		<!-- js -->
		<script type="text/javascript" src="/assets/script/prefixfree.min.js"></script> 
		<script type="text/javascript" src="/assets/script/jquery-1.12.4.min.js"></script> 
		<script type="text/javascript" src="/assets/script/foo-js-0.5.js"></script>  
		<script>
			$(function () {
				console.log('%c脚本加载完毕 ', 
				'background-image:-webkit-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );\n\
				color:transparent;\n\
				-webkit-background-clip: text;\n\
				font-size:3em;');
		
			});
		</script>
	</head>

<body>

	<h3 class="head">注册 <a class="btn-goback" href="/"></a></h3>
	<div class="login-container">
		<img class="login-img" src="/assets/image/enrolltop.png" alt=""/>
		<div class="login-content">
			<form class="register-form" action="<?php echo Url('Index/doregister'); ?>" method='post'>
				<input name="name" placeholder="用户名"/>
				<input name="pass" placeholder="密码"/>
				<input name="pass2" placeholder="再次输入密码"/>
				<button type="submit">注册</button>
			</form>
			<div class="btn-box">
				<a href="<?php echo Url('Index/login'); ?>">已有账号，立即登录</a>
			</div>
		</div>

	</div>
</body>
</html>

