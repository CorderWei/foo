<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"E:\WWW\foo\public/../application/../template/admin/user\auth_list.html";i:1508398827;}*/ ?>
<style>
	#list_cat span{
		display: inline-block;

		width:80px;
		height:60px;
		line-height: 60px;
		text-align: center;
		overflow: hidden;
	}
	.foo_update{
		color: #fff;
		background-color: #51a351; 
	}
	.cancle{
		color: #fff;
		background-color: #da4f49; 
	}
</style>
<div>
	<ul id="list_cat">
		<li>
			<span>用户ID</span>
			<span>用户账号</span>
			<span style="width:200px;">名称</span>
			<span>角色</span>
			<span>主业务</span>
			<span style="width:300px;">地址</span>
			<span>个人照</span>
			<span>认证照</span>
			<span>状态</span>
			<span>操作</span>
		</li>
		<?php if(is_array($pagedata) || $pagedata instanceof \think\Collection || $pagedata instanceof \think\Paginator): $i = 0; $__LIST__ = $pagedata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
		<li>
			<span class="action_btn" data-ctrl="User" data-act="auth_detail" 
				  data-data='{"id":"<?php echo $item['id']; ?>","table_name":"<?php echo $table_name; ?>"}'>
				<?php echo $item['id']; ?>
			</span>
			<span>
				<?php echo $item['user_name']; ?>
			</span>
			<span style="width:200px;">
				<?php echo $item['name']; ?>
			</span>
			<span>
				<?php echo $model_name; ?>
			</span>
			<span>
				<?php echo $item['cat_name']; ?>
			</span>
			<span style="width:300px;">
				<?php echo $item['address']; ?>
			</span>
			<span>
				<img src="<?php echo $item['owner_pic']; ?>" width="80" height="60"/>
			</span>

			<span>
				<?php switch($item['model_id']): case "1":case "5":case "6": ?>
				<img src="<?php echo $item['market_pic']; ?>" width="80" height="60"/>
				<?php break; case "4": ?>
				<img src="<?php echo $item['car_pic']; ?>" width="80" height="60"/>
				<?php break; default: endswitch; ?>
			</span>

			<span class="status">
				<?php if($item['is_auth'] == '0'): ?>
				未通过
				<?php else: ?>
				已通过
				<?php endif; ?>
			</span>
			<span>
				<?php if($item['is_auth'] == '0'): ?>
				<button class="foo_update" data-url="<?php echo Url('User/user_auth'); ?>" data-handle="U" data-table="<?php echo $table_name; ?>" data-model_id="<?php echo $base_id; ?>" data-cat_id="<?php echo $item['cat_id']; ?>" data-kn="id" data-kv="<?php echo $item['id']; ?>" data-fn="is_auth" data-fv="1" >通过</button>
				<?php else: ?>
				<button class="foo_update cancle" data-url="<?php echo Url('User/user_auth'); ?>" data-handle="U" data-table="<?php echo $table_name; ?>" data-model_id="<?php echo $base_id; ?>" data-cat_id="<?php echo $item['cat_id']; ?>" data-kn="id" data-kv="<?php echo $item['id']; ?>" data-fn="is_auth" data-fv="0" >撤销</button>
				<?php endif; ?>
			</span>
		</li>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<script>
	$(function () {
		foo.trans.ajaxJump('.action_btn', 'admin', function (page) {
			$("#content").html(page);
			return false;
		});
		$(".foo_update").click(function () {
			var binder = $(this);
			var url = binder.data(url);
			var data = binder.data();
			var status = binder.parents('li').find('.status');
			$.post(url, data, function (result) {
				if (result) {
					if (result['is_done'] > 0) {
						alert('更新成功');
						if (data['fv'] > 0) {
							binder.data('fv', '0');
							binder.addClass('cancle').text('撤销');
							status.text('已通过');

						}
						else {
							binder.data('fv', '1');
							binder.removeClass('cancle').text('通过');
							status.text('未通过');
						}
					}
					else {
						alert('更新失败');
					}
				}
			});
		});
	});
</script>
