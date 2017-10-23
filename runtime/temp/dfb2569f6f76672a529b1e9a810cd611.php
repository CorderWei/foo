<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:65:"E:\WWW\foo\public/../application/../template/pc/expert\index.html";i:1508765555;s:64:"E:\WWW\foo\public/../application/../template/pc/public\head.html";i:1508157721;s:66:"E:\WWW\foo\public/../application/../template/pc/public\header.html";i:1507862389;s:70:"E:\WWW\foo\public/../application/../template/pc/public\user_inter.html";i:1508549849;s:64:"E:\WWW\foo\public/../application/../template/pc/public\foot.html";i:1507516574;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="/assets/style/category.css" /> 
<body>
	<link rel="stylesheet" type="text/css" href="/assets/style/header.css" />
<link rel="stylesheet" type="text/css" href="/assets/style/swiper-3.4.2.min.css" />
<script type="text/javascript" src="/assets/script/swiper-3.4.2.jquery.min.js"></script>
<!--顶部入口-->
<div class="header">
	<a class="com_btn t-c btn-city" href="<?php echo Url('Index/citychange'); ?>"><?php echo $cur_city; ?></a>
	<a class="main_title" href="/">养殖天网首页</a>
	<a class="com_btn t-c btn-chat" href="<?php echo Url('Index/huanxin'); ?>">聊天室</a>
</div>
<!-- 轮播图 start -->
<div class="swiper-container lunbo-1">
    <div class="banner-bg"></div>
    <ul class="swiper-wrapper">
        <li class="swiper-slide"><img src="/assets/image/lunbo-1.jpg" alt=""/></li>
        <li class="swiper-slide"><img src="/assets/image/lunbo-2.jpg" alt=""/></li>
        <li class="swiper-slide"><img src="/assets/image/lunbo-3.jpg" alt=""/></li>
    </ul>
    <!-- 如果需要分页器 -->
    <div class="swiper-pagination"></div>
    <!-- 如果需要导航按钮 -->
    <!--<div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-button-next swiper-button-white"></div>-->
</div>
<script>
    $(function(){
        var mySwiper1 = new Swiper ('.lunbo-1', {
            direction: 'horizontal',
            autoplayDisableOnInteraction : false,
            loop: true,
            // 如果需要分页器
            pagination: '.swiper-pagination',
            paginationClickable :true,
            // 如果需要前进后退按钮
            //nextButton: '.swiper-button-next',
            //prevButton: '.swiper-button-prev',
            autoplay:4000
        });
    });
</script>
<!-- 轮播图 end -->

	<!--用户信息-->
	<div class="user-info-wrap">
	<span class="user-name"><?php echo \think\Session::get('user.name'); ?></span>
	<span class="grade">&starf;&starf;&starf;</span>
	<span class="basemodel-name">(<?php echo \think\Session::get('basemodel.name'); ?>)</span>
	<div class="user-bottom">
		<a href="<?php echo Url('User/index'); ?>">个人中心</a>
		<a href="<?php echo Url('Auth/auth_tpl'); ?>">信息认证</a>
	</div>
</div>

	<!--功能入口-->
	<ul class="interface clear">
		<li>
			<a href="<?php echo Url('Expert/course_list'); ?>">
				<img src="/assets/image/zhuanshu.png"/>
				<p>文章列表</p>
			</a>
		</li>
		<li>
			<a href="<?php echo Url('Expert/my_course'); ?>">
				<img src="/assets/image/zhuanshu.png"/>
				<p>我的发布</p>
			</a>
		</li>
		<li>
			<a href="<?php echo Url('Category/matter'); ?>">
                <img src="/assets/image/zhuanshu.png"/>
				<p>行情查询</p>
			</a>
		</li>
		<li>
			<a href="<?php echo Url('Expert/add_course'); ?>">
                <img src="/assets/image/zhuanshu.png"/>
				<p>发布文章</p>
			</a>
		</li>
		<?php if(is_array($market_cats) || $market_cats instanceof \think\Collection || $market_cats instanceof \think\Paginator): $i = 0; $__LIST__ = $market_cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mc): $mod = ($i % 2 );++$i;if($mc['id'] <= '2'): ?>
		<li>
			<a href="<?php echo Url('Goods/buy',array('acc_model_id'=>2,'mc_id'=>$mc['id'])); ?>">
                <img src="/assets/image/zhuanshu.png"/>
				<p><?php echo $mc['name']; ?></p>
			</a>
		</li>
		<?php else: ?>
		<li>
			<a href="<?php echo Url('Market/market_list',array('mc_id'=>$mc['id'])); ?>">
                <img src="/assets/image/zhuanshu.png"/>
				<p><?php echo $mc['name']; ?></p>
			</a>
		</li>
		<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		<li>
			<a href="<?php echo Url('Index/near'); ?>">
                <img src="/assets/image/zhuanshu.png"/>
				<p>附近会员</p>
			</a>
		</li>
	</ul>
</body>
</html>

