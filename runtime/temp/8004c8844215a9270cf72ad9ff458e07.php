<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"E:\WWW\foo\public/../application/../template/admin/index\index.html";i:1508804801;s:67:"E:\WWW\foo\public/../application/../template/admin/public\head.html";i:1508816494;s:67:"E:\WWW\foo\public/../application/../template/admin/public\foot.html";i:1507517183;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="/assets/admin/style/jquery-accordion-menu.css" />
<link rel="stylesheet" type="text/css" href="/assets/admin/style/font-awesome.css" />
<script type="text/javascript" src="/assets/admin/script/jquery-accordion-menu.js"></script>
<style>
	body{
		min-width: 1500px;
	}
	#title{
		width:100%;
		height:3em;
		padding:1em;
		vertical-align: middle;
		border-bottom: 1px solid #dfdfdf;
	}
	#menu{
		width:12%;
		min-height: 500px;
		background: #ED5565;
		float:left;
	}
	.filterinput {
        background-color: rgba(249, 244, 244, 0);
        border-radius: 15px;
        width: 90%;
        height: 30px;
        border: thin solid #FFF;
        text-indent: 0.5em;
        font-weight: bold;
        color: #FFF;
    }
	#menu-list .action_btn{
        overflow: hidden;
        text-overflow: ellipsis;
        -o-text-overflow: ellipsis;
        white-space: nowrap;
        width: 100%;
		border-bottom: 1px solid #565656;
    }
	#content{
		font-size: 14px;
		float:left; width: 1280px; padding: 1em; margin-left: 1em;
	}
</style>
<script>
	$(function () {
		$("#menu").jqueryAccordionMenu();
		// ajax跳转
		foo.trans.ajaxJump('.action_btn','admin',function(page){
			$("#content").html(page);
		});
	});
</script>
<body>
	<div id="title">
		养殖天网后台管理
	</div>
	<div id="menu" class="jquery-accordion-menu red" data-module="<?php echo $module; ?>">
		<!--菜单列表 插件使用了a死链的布局结构,后续再改写插件-->
		<ul id="menu-list" class="clear">
			<?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $k=>$vo): ?>
			<li data-param="map-<?php echo $k; ?>">
				<a href="###" class="submenu-indicator-minus"><?php echo $vo['name']; ?></a>
				<ul class="submenu">
					<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): if( count($vo['child'])==0 ) : echo "" ;else: foreach($vo['child'] as $key=>$v2): ?>
					<li>
						<a href="###" class="action_btn" data-ctrl="<?php echo $v2['op']; ?>" data-act="<?php echo $v2['act']; ?>">
							<?php echo $v2['name']; ?>
						</a>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<div id="content">

	</div>
</body>
</html>
