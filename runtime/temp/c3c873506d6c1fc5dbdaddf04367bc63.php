<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"E:\WWW\foo\public/../application/../template/pc/category\manage.html";i:1508121952;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:65:"E:\WWW\foo\public/../application/../template/pc/public\title.html";i:1508122697;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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

	<table class="product-online-table">
		<caption><h4 class="product-online-title"><span><?php echo $cur_city; ?></span>饲养场地信息管理</h4></caption>
		<tr>
			<th>栏号</th>
			<th>种类</th>
			<th>数量</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($k % 2 );++$k;?>
		<tr>
			<input class="foo_del" type="hidden" data-url="<?php echo Url('AjaxCrud/handle'); ?>" data-handle="D" data-table="Manage" data-KN="id" data-KV="<?php echo $item['id']; ?>"/>
			<td><?php echo $k; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td><?php echo $item['num']; ?></td>
			<td><button class="foo_trigger">删除</button></td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	
	<button class="btn btn-show-form" id="add">添加</button>
	<form id="add_form" class="none add_form" method="post" action="<?php echo Url('Category/manage'); ?>">
		<select name="cat_id">
			<option value="0">--请选择分类--</option>
			<?php if(is_array($son_cat) || $son_cat instanceof \think\Collection || $son_cat instanceof \think\Paginator): $i = 0; $__LIST__ = $son_cat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?>
			<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</select>
        <input placeholder="数量" name="num"/>
		<button class="foo_submit btn ">确定添加</button>
	</form>
	<script>
		$(function () {
			show_form_event();
			del_event();
		});
		// 【显示】动作的事件监听器
		function show_form_event() {
			$(document.body).on('click', "#add", function () {
				$("#add_form").toggle();
			});
		}
		// 【删除】动作的事件监听器
		function del_event() {
			$(document.body).on('click', ".foo_trigger", function () {
				if (confirm("您确定删除吗？")) {
					var binder = $(this).parents('tr').find('.foo_del');
					console.log(binder.data());
					var url = binder.data('url');
					$.post(url, binder.data(), function (data) {
						console.log(data);
						if (data.is_done > 0) {
							console.log('成功');
						}
						binder.parent('tr').remove();
					});
				}
			});
		}
	</script>
</body>
</html>

