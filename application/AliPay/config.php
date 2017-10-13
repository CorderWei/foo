<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016081900286781",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAm6aSBH9puCV9wqV/v5zmYCKY+kZZ1qD6B/eto/4nsSVKa1nXdFDfT48bq6TT9m4GDH+pJ9WMRlfobWvHoLZ11M00boLZOeixXz2b7UrC0Pldtjlrqh1pr8gLkP3TY053BcMbhgeFv7iZ3Z+ySf4K4ku18tAczQ+OH+TT9aBKJxyeW6fxt3bbbbjP1YqC51D57IC258gqd+Ppi3Og/OFWSBSvK/04WGPcyecSuXdX8S5ykEbfM4DCWdV4n4jo1f4EqcgUrhNA+oQgJqvGjgCklJXjqp/Gx2FtQmjliHzNogqcVsbemmMC0ZZuwcns2IiZYm3j3wEYjFLrbCGornAzcQIDAQABAoIBAFV267w+fb0YEOqc1v1OWIy20oqxsEiSUVeonpZqSj8Re8BgL1Z1xXg42vevZJduKDIasrXlosVJJZ1XTeCn7yEun7iCbmZGp4XlHUX5A+mc0uDovH5G8i4LyJYPWU+w2Ne4HtfEL6Nq6Elxk4LfU/iXm8s8jGPoQ6Ctk9jN74lzaSHHH75GO3pYuCnxy72ry62NBu8WZTsYa7AQ55UqZqylfEq/FnsHK5bAk75SutEkhAllxs4V905+1x8O8q6cmsEf98qGSaPDJBDXtWR3NzSrGr/igWFs6QZyaT/M8t731OuPamf73qb7CznPMqKkm0Qb0YArkLgUTYqZXUEK+kECgYEAygQO2BcyPiKTpRlGp4gp4JLXclDHk8EwV9mUlqZ7aaq2nf3tJZwXrLY5B7UAAnLbYW9xLGV0dQ2OQGqsmfvPidbgF1d+q3o9296F9BO2v09cPeRTZQ9e/0bJGjtW9uZYkqr3VNxBBXc2UhvofLpksS+oB+FsAlz8tAMWjY9MhLkCgYEAxT6pUQVAo7EsgUmi4cG+LZvRLKhEDJrJzVmYeKQG7I62GNyKNo+qmCRh7Q+PjJ09aQ8QrDYLEYPd1ZlYrZnEyIo5QurfbEKrC8K3vpI+mcxKcrIUDsTnvdQoyPHxpvvuOUEgKYAqznyPjA4w+FxLUdSElVc7xS3xOHpnA4OlOHkCgYEAku3UphJo9oxLen8hxmPgoXfrvzdFkQ+ny51y1weLJ1WEsPCo9PvMtE9st1BMC3viV8GoPLQluaT8W5m6o9xkHErufcujU7D7INl98AIOnqJn4pQYm55MZ7riNXQHUlhC/5ndfhkcKY+FML8fnugqqDyTJ/gqiKV9HqhIVPlum/ECgYA66Uo8zqrNuT8npkylzO32RVGmWuNoOFsJoDbv4V3IDZ/JsST+ws4a/tLYsQsY3mXXGQ7LwKBxrMb24wQfZYvmsZIEsI3mkcrwiknC+38DBIc/1nwzJRBqHBHKYqjgTOKL6y2l94fRgFaHaD2sEDTWzfiDejh53gzr53MZE5qnUQKBgA1dNT76dbXcxJxFlJ5JE/qB48W11/09DYGulWmUYZioNPY0aK8ssNEPCaFnUq2zT2WNB3+m/BjROf/k5MEVHhtsU5Llkso9ekd9XEQfVmpRn4OGLFtdcdSddcOQDswJbD+y0dw5QioOuA1GsNCsNb1wE3gvkiarlutItlY3AshA",
		
		//异步通知地址
		'notify_url' => "http://localhost/yangzhi/index.php/Home/Ajump/send",//"http://工程公网访问地址/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://localhost/yangzhi/index.php/Home/Ajump/index",//"http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApdPcDC91csq48xHGsVlWyJk8DulV65YH1I7ExHi0BaUtnHJ864AJaE3TZGhgnSqYgqK/Sv3F08f42gbjImM0xK064b2DwPwnb7zt9/zd5PC+poOgGvCV8/tzZu8JSznEV/iokSO+XGyIX0LybQTyjGqSODJ9BbtjDPSVeDVgHXUtp1XsSidP9Yy37conlsOvZ4v5eg4kJ9nyPdCl/ic1XyFOlQBX4VnH0uazcwcwl0kA8UXboB54o69AG2UA4ZWCC7q3jiiFnQarxVwpAicM206qJLGk9NRIsordXrUGQBoPFIy3jl1GrhWkI1rtyiSslS11WTVMDQkXSoxznWh7gQIDAQAB",
);