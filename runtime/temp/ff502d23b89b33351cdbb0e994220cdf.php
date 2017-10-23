<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"E:\WWW\foo\public/../application/../template/pc/index\citychange.html";i:1507947438;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:70:"E:\WWW\foo\public/../application/../template/pc/public\citychange.html";i:1508742261;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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
	<h3 class="head">养殖天网 <a class="btn-goback" href="/"></a></h3>
	<div class="city-select-box">
		<label class="select-desc">所在地点</label>
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
  
		<button id="note_city" data-url="<?php echo Url('Index/note_city'); ?>">确定</button>
	</div>
	<script>
		$('#note_city').click(function () {
			var pro_id = $("#pro").val();
			var city_id = $("#city").val();
			var area_id = $("#area").val();
			var pro_name = $("#pro").find("option:selected").text();
			var city_name = $("#city").find("option:selected").text();
			var area_name = $("#area").find("option:selected").text();
			if (city_id == 0) {
				alert('请选择具体城市');
				return false;
			}

			if (area_id == 0) {
				alert('请选择具体地区');
				return false;
			}
			var url = "<?php echo Url('Index/note_city'); ?>";
			var data = {
				"pro_id": pro_id,
				"city_id": city_id,
				"area_id": area_id,
				"pro_name": pro_name,
				"city_name": city_name,
				"area_name": area_name
			};
			$.ajax({
				type: "post",
				url: "<?php echo Url('Index/note_city'); ?>",
				data: data,
				dataType: "json",
				success: function (data) {
					location.href = "<?php echo Url('Index/index'); ?>";
				}
			});
		});
	</script>
</body>
</html>
