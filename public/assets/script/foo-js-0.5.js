/**
 * foo-js 0.5版本 
 * @wxl 2017-10-2
 * 
 */

foo = {};
foo.trans = {};

/**
 * ajax 方式提交form  
 * 
 * 使用条件 : form标签中用data-url属性指定路径, 提交触发器的类名为foo_submit
 * 
 * @param {string} selector  表单元素选择器
 * @param {bool || function} validate  通过验证标记 or 用于验证的ajax前置函数
 * @param {function} callback  ajax回调函数
 * @param {int} flag  数据传输格式, 不填写则为json, 非0为serialize
 * @returns {undefined}
 */

foo.trans.ajaxForm = function (selector, validate, callback, flag) {
	var form = $(selector);
	var trig = form.find(".foo_submit");
	var url = form.data('url');

	trig.on('click', function () {
		if (flag > 0) {
			var data = $(selector).serialize();
		}
		else {
			var array = form.serializeArray();
			var data = foo.trans.array2Json(array);
		}
		if (validate && typeof (validate) === "function") {
			var validate_result = validate(data);
		}
		if (validate || validate_result) {
			$.post(url, data, callback, "text");
		}
	});
};

// Helper

/**
 * 将序列化的数组转换成Json
 * @param {Array} serialize_Array
 * @returns {Object}
 */
foo.trans.array2Json = function (serialize_Array) {
	var o = {};
	var a = serialize_Array;
	$.each(a, function () {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		}
		else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};

