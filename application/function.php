<?php

	// 获取当前用户IP
	function GetIp()
	{
		$realip = '';
		$unknown = 'unknown';
		if (isset($_SERVER))
		{
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown))
			{
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($arr as $ip)
				{
					$ip = trim($ip);
					if ($ip != 'unknown')
					{
						$realip = $ip;
						break;
					}
				}
			}
			else if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown))
			{
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			}
			else if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown))
			{
				$realip = $_SERVER['REMOTE_ADDR'];
			}
			else
			{
				$realip = $unknown;
			}
		}
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown))
			{
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			}
			else if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown))
			{
				$realip = getenv("HTTP_CLIENT_IP");
			}
			else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown))
			{
				$realip = getenv("REMOTE_ADDR");
			}
			else
			{
				$realip = $unknown;
			}
		}
		$realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
		return $realip;
	}

	/**
	 * 新浪接口，根据坐标查询当前所在省市区
	 * @param type $ip
	 * @return boolean|string
	 */
	function GetIpLookup($ip = '')
	{
		if (empty($ip))
		{
			$ip = GetIp();
		}
		$ip = '112.243.45.146'; //TEST
		$res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
		if (empty($res))
		{
			return false;
		}
		$jsonMatches = array();
		preg_match('#\{.+?\}#', $res, $jsonMatches);
		if (!isset($jsonMatches[0]))
		{
			return false;
		}
		$json = json_decode($jsonMatches[0], true);
		if (isset($json['ret']) && $json['ret'] == 1)
		{
			$json['ip'] = $ip;
			unset($json['ret']);
		}
		else
		{
			return false;
		}
		return $json;
	}

	/**
	 * 百度地图根据IP获取坐标
	 * @param type $ip
	 * @return type
	 */
	function get_baidu_city($ip = '')
	{
		if (empty($ip))
		{
			$ip = GetIp();
		}
		$ip = '112.243.45.146'; //TEST
		$url = "https://api.map.baidu.com/location/ip?ip=$ip&ak=nYPxjmQB6d0155v3adI4MGaSCPAf82Um&coor=bd09ll";
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
		$tmpInfo = curl_exec($curl);  //返回api的json对象
		//关闭URL请求
		curl_close($curl);
		return json_decode($tmpInfo, true);
	}

	/**
	 * 获取当前坐标并存入cookie
	 * @return array   array['x']北纬  array['y']东经
	 */
	function GetCoord()
	{
		$coord = cookie('TW_coord');
		if (isset($coord))
		{
			$coord = unserialize(cookie('TW_coord'));
			return $coord;
		}
		else
		{
			$city = get_baidu_city();
			if (array_key_exists('content', $city))
			{
				$coord = $city['content']['point'];
				cookie('TW_coord', serialize($coord));
			}
			return $coord;
		}
	}
	/**
	 * 获取当前城市名称
	 * @return string
	 */
	function GetCurrentCityName()
	{
		if (session('?position'))
		{
			$cur_city = session('position.city_name');
		}
		else
		{
			$look = GetIpLookup();
			if (array_key_exists('city', $look))
			{
				$cur_city = $look['city'];
			}
			else
			{
				$cur_city = '选择';
			}
		}
		return $cur_city;
	}
	
	/**
	 * 判断当前用户是否具备当前认证模型下某业务领域的权限
	 * @param type $cat_id  业务领域编码，业务领域为猪，牛，鸡等
	 * @return boolean
	 * 认证模型即 饲养户,厂商,专家,运输车等
	 */
	function is_authed($cat_id){
		$base_id = session('basemodel.id');
		$cat_ids = session('user.cat_ids');
		$auth_code = $base_id.'_'.$cat_id;
		if(empty($cat_ids)){
			return false;
		}else{
			$auths = explode(',',$cat_ids);
			if(in_array($auth_code, $auths)){
				return true;
			}
		}
		return false;
	}