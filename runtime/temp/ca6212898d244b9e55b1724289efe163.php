<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"E:\WWW\foo\public/../application/../template/pc/goods\buy.html";i:1508122141;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:65:"E:\WWW\foo\public/../application/../template/pc/public\title.html";i:1508122697;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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

	<table class="product-online-table food-table">
		<caption><h4 class="product-online-title"><span><?php echo $cur_city; ?></span>在线抢单</h4></caption>
		<tr>
			<th>地区</th>
			<th>品种</th>
			<th>单价(元)</th>
			<th>数量</th>
			<th>合计(元)</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
		<tr>
			<form class="hidden_form" action="<?php echo Url('Goods/make_order'); ?>" method="post">
				<input name="pro" type="hidden" value="<?php echo $item['pro']; ?>"/>
				<input name="city" type="hidden" value="<?php echo $item['city']; ?>"/>
				<input name="area" type="hidden" value="<?php echo $item['area']; ?>"/>

				<input name="cat_id" type="hidden" value="<?php echo $item['cat_id']; ?>"/>
				<input name="cat_name" type="hidden" value="<?php echo $item['cat_name']; ?>"/>
				<input name="seller_id" type="hidden" value="<?php echo $item['user_id']; ?>"/>
				<input name="seller_name" type="hidden" value="<?php echo $item['user_name']; ?>"/>

				<input name="price" type="hidden" value="<?php echo $item['price']; ?>"/>
				<input name="num" type="hidden" value="<?php echo $item['num']; ?>"/>
				<input name="total" type="hidden" value="<?php echo $item['total']; ?>"/>
			</form>
			<td><?php echo $item['region_name']; ?></td>
			<td><?php echo $item['cat_name']; ?></td>
			<td><?php echo $item['price']; ?></td>
			<td><?php echo $item['num']; ?></td>
			<td><?php echo $item['total']; ?></td>
			<td><button class="dobuy">抢单</button></td>
		</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<!--<ul>
		<li>
			<span>地区</span>
			<span>供货人</span>
			<span>品种</span>
			<span>价格</span>
			<span>数量</span>
			<span>合计</span>
			<span>上架时间</span>
			<span>操作</span>
		<li>
			-&#45;&#45;&#45;&#45;&#45;&#45;下方 | 线只是分割作用，修改样式时删除掉！ 本行也删除-&#45;&#45;&#45;&#45;
			<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
		<li>
			<form class="hidden_form" action="<?php echo Url('Goods/make_order'); ?>" method="post">
			<input name="pro" type="hidden" value="<?php echo $item['pro']; ?>"/>
			<input name="city" type="hidden" value="<?php echo $item['city']; ?>"/>
			<input name="area" type="hidden" value="<?php echo $item['area']; ?>"/>
			
			<input name="cat_id" type="hidden" value="<?php echo $item['cat_id']; ?>"/>
			<input name="cat_name" type="hidden" value="<?php echo $item['cat_name']; ?>"/>
			<input name="seller_id" type="hidden" value="<?php echo $item['user_id']; ?>"/>
			<input name="seller_name" type="hidden" value="<?php echo $item['user_name']; ?>"/>
			
			<input name="price" type="hidden" value="<?php echo $item['price']; ?>"/>
			<input name="num" type="hidden" value="<?php echo $item['num']; ?>"/>
			<input name="total" type="hidden" value="<?php echo $item['total']; ?>"/>
			</form>
			
			<span><?php echo $item['region_name']; ?></span>|
			<span>
				<a href="<?php echo Url('User/people',array('id'=>$item['user_id'])); ?>"><?php echo $item['user_name']; ?></a>
			</span>|
			<span><?php echo $item['cat_name']; ?></span>|
			<span><?php echo $item['price']; ?>元/只</span>|
			<span><?php echo $item['num']; ?></span>|
			<span><?php echo $item['total']; ?>元</span>|
			<span><?php echo $item['add_time']; ?></span>|
			<button class="dobuy">抢单</button>
		</li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>-->
	<script>
		$(function(){
			submit_event();
		});
		function submit_event(){
			$(document.body).on('click', ".dobuy", function () {
				var form = $(this).parents('tr').find('.hidden_form');
				form.submit();
			});
		}
	</script>
</body>
</html>

