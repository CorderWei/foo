<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"E:\WWW\foo\public/../application/../template/pc/goods\goods_list.html";i:1508372242;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:65:"E:\WWW\foo\public/../application/../template/pc/public\title.html";i:1508122697;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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

<caption><h4 class="product-online-title"><span><?php echo $cur_city; ?></span>我已上架的产品列表</h4></caption>
<div id="search">
	<form action="" method="post">
		<span>种类:</span>
		<select id="search" name="son_id">
			<option value="0">--所有--</option>
			<?php if(is_array($son_cat) || $son_cat instanceof \think\Collection || $son_cat instanceof \think\Paginator): $i = 0; $__LIST__ = $son_cat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;if($cat['id'] == $select_id): ?>
			<option value="<?php echo $cat['id']; ?>" selected="selected"><?php echo $cat['name']; ?></option>
			<?php else: ?>
			<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</select>
		<span>价格区间:</span>
		<input name="min_price"/>元——<input name="max_price"/>元
		<input type="submit" value="查询"/>
	</form>
</div>
<table class="product-online-table">
	<tr>
		<th>地区</th>
		<th>品种</th>
		<th>数量</th>
		<th>单价(元)</th>
		<th>上架时间</th>
		<th>操作</th>
	</tr>
	<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
	<tr>
	<input class="foo_update" type="hidden" data-url="<?php echo Url('AjaxCrud/handle'); ?>" data-handle="U" data-table="Goods" data-KN="id" data-KV="<?php echo $item['id']; ?>" data-FN="on_sell" data-FV="0"  />
	<td><?php echo $item['region_name']; ?></td>
	<td><?php echo $item['cat_name']; ?></td>
	<td><?php echo $item['num']; ?></td>
	<td><?php echo $item['price']; ?></td>
	<td><?php echo date('Y-m-d',$item['add_time']); ?></td>
	<td><button class="foo_trigger">下架</button></td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
</table>

<button class="btn btn-show-form" id="add">添加</button>
<form id="add_form" class="none add_form" method="post" action="<?php echo Url('Goods/add_goods'); ?>">
	<select name="cat_id">
		<option value="0">--请选择分类--</option>
		<?php if(is_array($son_cat) || $son_cat instanceof \think\Collection || $son_cat instanceof \think\Paginator): $i = 0; $__LIST__ = $son_cat;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?>
		<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</select>
	<input placeholder="数量" name="num"/>
	<input placeholder="单价(元)" name="price"/>
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
			if (confirm("您确定下架吗？")) {
				var binder = $(this).siblings('.foo_update');
				console.log(binder.data());
				var url = binder.data('url');
				$.post(url, binder.data(), function (data) {
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

