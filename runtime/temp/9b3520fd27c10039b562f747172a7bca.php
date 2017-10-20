<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"E:\WWW\foo\public/../application/../template/admin/index\login.html";i:1508251410;s:67:"E:\WWW\foo\public/../application/../template/admin/public\head.html";i:1508391483;s:67:"E:\WWW\foo\public/../application/../template/admin/public\foot.html";i:1507517183;}*/ ?>
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
		<!-- js -->
		<script type="text/javascript" src="/assets/script/prefixfree.min.js"></script> 
		<script type="text/javascript" src="/assets/script/jquery-1.12.4.min.js"></script> 
		<script type="text/javascript" src="/assets/script/foo-js-0.5.js"></script> 
		<script>
			$(function () {
				console.log(123);
			});
		</script>
	</head>

<body>
    <h3 class="head">管理员登录 <a class="btn-goback" href="/"></a></h3>
    <div class="login-container">
<!--        <img class="login-img" src="/assets/image/enrolltop.png" alt=""/>-->
        <div class="login-content">
            <form class="login-form" action="<?php echo Url('Index/dologin'); ?>" method='post'>
                <input name="name" placeholder="用户名"/>
                <input name="pass" placeholder="密码"/>
                <button type="submit">登录</button>
            </form>
<!--            <div class="btn-box">
                <a href="<?php echo Url('Index/register'); ?>">还没有账号？点击注册</a>
            </div>-->
        </div>

    </div>
</body>
</html>


