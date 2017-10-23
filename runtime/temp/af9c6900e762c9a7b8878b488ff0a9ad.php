<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:71:"E:\WWW\foo\public/../application/../template/pc/market\market_list.html";i:1508746622;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:65:"E:\WWW\foo\public/../application/../template/pc/public\title.html";i:1508556537;s:70:"E:\WWW\foo\public/../application/../template/pc/public\citychange.html";i:1508742261;s:72:"E:\WWW\foo\public/../application/../template/pc/market\_market_list.html";i:1508746747;s:68:"E:\WWW\foo\public/../application/../template/pc/public\paginate.html";i:1508743915;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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

	<div>
		<form data-url="<?php echo Url('Market/market_list'); ?>" id="search_form">
			<input type="hidden" name="mc_id" value="<?php echo $mc_id; ?>">
			<div class="serach_condi">
				<link rel="stylesheet" type="text/css" href="/assets/style/citychange.css" />
				<script type="text/javascript" src="/assets/script/citychange.js"></script>
<!-- 城市切换公用模板，搭配公用函数使用-->
<!-- 省份 -->
<select name="pro" id="pro" data-url="<?php echo Url('Index/citychange'); ?>">
	<?php if(is_array($region) || $region instanceof \think\Collection || $region instanceof \think\Paginator): if( count($region)==0 ) : echo "" ;else: foreach($region as $key=>$v): if(\think\Session::get('position.pro_id') == $v['region_id']): ?>
	<option value="<?php echo $v['region_id']; ?>" selected><?php echo $v['region_name']; ?></option>
	<?php else: ?>
	<option value="<?php echo $v['region_id']; ?>"><?php echo $v['region_name']; ?></option>
	<?php endif; endforeach; endif; else: echo "" ;endif; ?>
</select>
<!-- 城市 -->
<select name="city" id="city" data-url="<?php echo Url('Index/citychange'); ?>">
	<option></option>
</select>
<!-- 区县 -->
<select name="area" id="area">
	<option></option>
</select>

				<span class="foo_submit">筛选</span>	
			</div>
		</form>
	</div>
	<!-- 厂区列表-->
	<div id="market_list">
	<table class="product-online-table">
	<tr>
		<th>名称</th>
		<th>地址</th>
		<th>联系电话</th>
	</tr>
	<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
	<tr>
		<td><?php echo $item['name']; ?></a></td>
		<td><?php echo $item['address']; ?></td>
		<td><?php echo $item['phone']; ?></td>
	</tr>
	<div class="none"><a href="<?php echo Url('Market/market_manage',['id'=>$item['id']]); ?>"></a></div>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</table>

	</div>
	<!-- 分页-->
	<style>
	.pagination{ 
		text-align:center; 
		background:#f1f1f1; 
		padding:7px 0; 
		margin-top: 30px;
	}
	.pagination:after { 
		content: "\0020"; 
		display: block; 
		height: 0; 
		clear: both; 
	}
	.pagination li{ 
		float:left;
	}
	.pagination a{ 
		margin:0 5px; 
		border:#DA4453 solid 1px; 
		display:inline-block; 
		padding:2px 6px 1px; 
		line-height:16px; 
		background:#fff; color:#DA4453;
	}
	.pagination span{ 
		margin:0 5px;
		border:#DA4453 solid 1px;
		display:inline-block;
		padding:2px 6px 1px; 
		line-height:16px; color:#DA4453; 
		color:#fff; background:#DA4453;
	}
</style>
<?php echo $paginate; ?>
</body>
<script>
	$(function () {
		foo.trans.ajaxForm('#search_form', true, function (list) {
			console.log(list);
			$("#market_list").html(list);
		});
	});
</script>
</html>

