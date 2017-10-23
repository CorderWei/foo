<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"E:\WWW\foo\public/../application/../template/pc/index\changepass.html";i:1507950820;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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
	<h3 class="head">修改密码 <a class="btn-goback" href="/"></a></h3>
	<form class="modify-psw-form" method="post" action="">

		<div class="input-box">
			<!--<span class="am-input-group-label"><i class="am-icon-money am-icon-fw"></i></span>-->
			<label>初始密码:</label>
			<input type="password" name="old" class="" placeholder="填写初始密码">
			<span class="old warning-text"></span>
		</div>
		<div class="input-box">
			<label>新密码:</label>
			<input type="password" name="xin" class="" placeholder="填写新密码">
			<span class="xin warning-text"></span>
		</div>
		<div class="input-box">
			<label>确认密码:</label>
			<input type="password" name="que" class="" placeholder="再次确认新密码">
			<span class="que warning-text"></span>
		</div>

		<button type="submit" id="sub" class="btn btn-modify">提交修改</button>

	</form>
</body>
<script>
// made by hs	
$(function(){
	var old,xin,que;
	var oldbool = false;
	var xinbool = false;
	var quebool = false;
	$('#sub').click(function(){
		var old = $('input[name=old]').val();
		var xin = $('input[name=xin]').val();
		var que = $('input[name=que]').val();
		if(old.length == 0){
			$('.old').html('请填写密码');
		}else if(old.length > 16 || old.length < 6){
			$('.old').html('密码格式在6位与16位之间');
		}else{
			oldbool = true;
			$('.old').html('');
		}

		if(xin.length == 0){
			$('.xin').html('请填写密码');
		}else if(xin.length > 16 || xin.length < 6){
			$('.xin').html('密码格式在6位与16位之间');
		}else{
			xinbool = true;
			$('.xin').html('');
		}

		if(que != xin){
			$('.que').html('两个密码不相同');
		}else{
			quebool = true;
			$('.que').html('');
		}
		if(oldbool && xinbool && quebool){
			return true;
		}else{
			return false;
		}
	});
});
</script>
</html>

