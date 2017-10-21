<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:66:"E:\WWW\foo\public/../application/../template/pc/auth\auth_tpl.html";i:1508544275;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:65:"E:\WWW\foo\public/../application/../template/pc/public\title.html";i:1508122697;s:70:"E:\WWW\foo\public/../application/../template/pc/public\citychange.html";i:1507772516;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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
<div class="header">
	<span class="com_btn t-c btn-city back">返回</span>
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

	<h4 class="cur-page-title"><?php echo \think\Session::get('basemodel.name'); ?>用户信息认证</h4>
	<form class="auth-form" action="<?php echo Url('Auth/doAuth'); ?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="model_id" value="<?php echo \think\Session::get('basemodel.id'); ?>"/>
		<input type="hidden" name="user_id" value="<?php echo \think\Session::get('user.id'); ?>"/>
		<?php if(\think\Session::get('basemodel.id') == '1'): ?>
		<div>
			<label>业务范畴:</label>	
			<select name="cat_id">
				<option value="0">请选择业务范畴</option>
				<?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;if($cat['id'] == $auth_catid): ?>
				<option value="<?php echo $cat['id']; ?>" selected="selected"><?php echo $cat['name']; ?></option>
				<?php else: ?>
				<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<?php endif; if(\think\Session::get('basemodel.id') == '2'): ?>
		<div>
			<label>厂区类型:</label>	
			<select name="mc_id">
				<option value="0">请选择业务范畴</option>
				<?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;if($cat['id'] == $auth_catid): ?>
				<option value="<?php echo $cat['id']; ?>" selected="selected"><?php echo $cat['name']; ?></option>
				<?php else: ?>
				<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
		<?php endif; ?>
		<div>
			<label>身份证:</label>
			<input name="card_no" />
		</div>
		<div>
			<label>正式名称:</label>
			<input name="name" />
		</div>
		<div>
			<label>归属地:</label>
			<div class="select-box">
				<script type="text/javascript" src="/assets/script/citychange.js"></script>
<!-- 城市切换公用模板，搭配公用函数使用-->
<!-- 省份 -->
<select name="pro" id="pro" data-url="<?php echo Url('Index/citychange'); ?>">
	<?php if(is_array($region) || $region instanceof \think\Collection || $region instanceof \think\Paginator): if( count($region)==0 ) : echo "" ;else: foreach($region as $key=>$v): ?>
	<option value="<?php echo $v['region_id']; ?>"><?php echo $v['region_name']; ?></option>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</select>
<!-- 城市 -->
<select name="city" id="city" data-url="<?php echo Url('Index/citychange'); ?>">
	<option></option>
</select>
<!-- 区县 -->
<select name="area" id="area">
	<option></option>
</select>

			</div>
		</div>
		<div>
			<label>地址:</label>
			<input name="address" />
		</div>
		<div>
			<label>联系电话:</label>
			<input name="phone" />
		</div>
		<div>
			<h3 class="upload-title">上传个人证件照</h3>
			<input hidden type="file" name="owner_pic" id="owner_pic" multiple="multiple"  />
			<label class="pic-box" for="owner_pic">
				<img src="/assets/image/need_add_pic.png" id="owner_pic_preview" alt="" />
			</label>
		</div>
		<div>
			<textarea rows="6" name="intro" placeholder="简介说明"></textarea>
		</div>
		<?php switch(\think\Session::get('basemodel.id')): case "1": ?>
		<!-- 饲养户附加信息 -->
		<div>
			<label>容量(只):</label>
			<input name="capacity" />
		</div>
		<div>
			<h3 class="upload-title">上传养殖场地照片</h3>
			<input hidden type="file" name="market_pic" id="market_pic" multiple="multiple"  />
			<label class="pic-box" for="market_pic">
				<img src="/assets/image/need_add_pic.png" id="market_pic_preview" alt="" />
			</label>
		</div>
		<?php break; case "2": ?>
		<!-- 厂区用户附加信息 -->
		<div>
			<label>营业执照编号:</label>
			<input name="license" />
		</div>
		<div>
			<h3 class="upload-title">上传厂区照片</h3>
			<input hidden type="file" name="market_pic" id="market_pic" multiple="multiple"  />
			<label class="pic-box" for="market_pic">
				<img src="/assets/image/need_add_pic.png" id="market_pic_preview" alt="" />
			</label>
		</div>
		<?php break; case "3": ?>
		<!-- 专家用户附加信息 -->
		<div>
			<label>毕业院校:</label>
			<input name="school_name" />
		</div>
		<div>
			<label>毕业院校地址:</label>
			<input name="school_address" />
		</div>
		<div>
			<label>资质证件说明及编号:</label>
			<input name="license" />
		</div>
		<?php break; case "4": ?>
		<!-- 运输车用户附加信息 -->
		<div>
			<label>车牌号:</label>
			<input name="car_no" />
		</div>
		<div>
			<label>驾驶证编号:</label>
			<input name="car_license" />
		</div>
		<div>
			<label>配送半径:(公里)</label>
			<input name="radius" />
		</div>
		<div>
			<input hidden type="file" name="car_pic" id="car_pic" multiple="multiple"  />
			<h3 class="upload-title">上传车辆照片</h3>
			<label class="pic-box" for="car_pic">
				<img src="/assets/image/need_add_pic.png" id="car_pic_preview" alt="" />
			</label>
		</div>
		<?php break; default: endswitch; ?>
		<input type="submit" value="提交"/>
	</form>
</body>
<script>
	$(function () {
		// 挂载事件监听
		addEventListener();
		// 挂载提交验证监听
		addValidateListener();
	});


	function addEventListener() {
		// 图片预览监听
		var owner_pic_preview = document.querySelector('#owner_pic_preview');
		var owner_pic = document.querySelector('#owner_pic');
		if (owner_pic_preview && owner_pic) {
			owner_pic.onchange = function () {
				var url = foo.trans.getObjUrl(owner_pic.files[0]);
				if (url) {
					owner_pic_preview.src = url;
				}
			};
		}
		var market_pic_preview = document.querySelector('#market_pic_preview');
		var market_pic = document.querySelector('#market_pic');
		if (market_pic_preview && market_pic) {
			market_pic.onchange = function () {
				var url = foo.trans.getObjUrl(market_pic.files[0]);
				console.log(url);
				if (url) {
					market_pic_preview.src = url;
				}
			};
		}
		var car_pic_preview = document.querySelector('#car_pic_preview');
		var car_pic = document.querySelector('#car_pic');
		if (car_pic_preview && car_pic) {
			car_pic.onchange = function () {
				var url = foo.trans.getObjUrl(car_pic.files[0]);
				if (url) {
					car_pic_preview.src = url;
				}
			};
		}
	}

	function addValidateListener() {

	}
</script>
</html>

