/**
 * 城市切换公用函数
 * @returns {undefined}
 */
$(function () {
	$('#pro').change(function () {
		$.ajax({
			type: "post",
			url: $(this).data('url'),
			data: 'pro_id=' + $('#pro').val(),
			dataType: "json",
			success: function (data) {
				$('#city').html(data);
			}
		});
	});
	$('#city').change(function () {
		$.ajax({
			type: "post",
			url: $(this).data('url'),
			data: 'pro_id=' + $('#city').val(),
			dataType: "json",
			success: function (data) {
				$('#area').html(data);
			}
		});
	});
	$('#pro').change();
});



