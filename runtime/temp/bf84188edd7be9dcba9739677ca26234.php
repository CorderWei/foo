<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"E:\WWW\foo\public/../application/../template/pc/expert\add_course.html";i:1508393198;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:65:"E:\WWW\foo\public/../application/../template/pc/public\title.html";i:1508556537;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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
	<link rel="stylesheet" type="text/css" href="/assets/style/header.css" />
<script type="text/javascript" src="/assets/script/jquery-1.12.4.min.js"></script>
<!--顶部入口-->
<?php $ctrl_name = think\Session::get('basemodel.ctrl_name'); $act_name = think\Session::get('basemodel.act_name'); ?>
<div class="header">
	<a class="com_btn t-c btn-city" href='<?php echo Url("$ctrl_name/$act_name"); ?>'>返回</a>
	<a class="main_title" href="/">养殖天网首页</a>
	<a class="com_btn t-c btn-chat" href="<?php echo Url('Index/huanxin'); ?>">聊天室</a>
</div>
<script>
	$(function () {
		$('body').on('click', '.back', function () {
			history.back();
		});
	});
</script>

	<form class="auth-form" action="" enctype="multipart/form-data" method="post">
		<input type="hidden" name="model_id" value="<?php echo \think\Session::get('basemodel.id'); ?>"/>
		<input type="hidden" name="user_id" value="<?php echo \think\Session::get('user.id'); ?>"/>
		<div>
			<label>标题</label>
			<input name="title"/>
		</div>
		<div>
			<label>描述</label>
			<input name="desc"/>
		</div>
		<div>
			<textarea rows="6" name="content" placeholder="此处输入内容"></textarea>
		</div>
		<div>
			<h3 class="upload-title">附加图片</h3>
			<input hidden type="file" name="thumb" id="course_pic" multiple="multiple"  />
			<label class="pic-box" for="course_pic">
				<img src="/assets/image/need_add_pic.png" id="course_pic_preview" alt="" />
			</label>
		</div>
		
		<input type="submit" value="提交"/>
	</form>
	<script>
	$(function () {
		// 挂载事件监听
		addEventListener();
		// 挂载提交验证监听
		//addValidateListener();
	});

	function addEventListener() {
		// 图片预览监听
		var course_pic_preview = document.querySelector('#course_pic_preview');
		var course_pic = document.querySelector('#course_pic');
		if (course_pic_preview && course_pic) {
			course_pic.onchange = function () {
				var url = foo.trans.getObjUrl(course_pic.files[0]);
				if (url) {
					course_pic_preview.src = url;
				}
			};
		}
	}
	</script>
</body>
</html>

