<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"E:\WWW\foo\public/../application/../template/admin/user\auth_cate.html";i:1508372741;}*/ ?>
<style>
	#list_cat li{
		float: left;
		width: 45%;
		height: 50px;
		border:1px solid #DA4453;
		border-radius: 5px;
		text-align: center;
		line-height: 50px;
		cursor: pointer;
		transition: 0.6s;
		margin:10px;
	} 
	#list_cat li:hover{
		color:#fff;
		background-color: #DA4453;
	}
</style>
<div>
	<ul id="list_cat">
	<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?>
	<li class="auth_btn" data-ctrl="User" data-act="auth_list" 
			  data-data='{"base_id":"<?php echo $cate['id']; ?>",
			  "table_name":"<?php echo $cate['table_name']; ?>",
			  "model_name":"<?php echo $cate['name']; ?>"}'>
		<span>
			<?php echo $cate['name']; ?>申请认证
		</span>
	</li>
	<?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<script>
$(function () {
	foo.trans.ajaxJump('.auth_btn', 'admin', function (page) {
		$("#content").html(page);
		return false;
	});
});
</script>