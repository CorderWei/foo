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

	// 使用curl函数向指定接口提交json格式数据
	function json_curl($url, $data, $header = false, $method = "POST")
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($header)
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if ($data)
		{   // 默认json格式发送数据
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}
	/**
	 * 注册环信
	 * @param type $name
	 * @param type $pass
	 * @return type
	 */
	function huanxin_reg($name,$pass)
	{
		// 注册环信  start //
		$data = array(
			'username' => $name,
			'password' => $pass,
			'appKey' => '1194170904115576#myapp',
			'apiUrl' => 'http://a1.easemob.com'
		);
		$res = json_curl('http://a1.easemob.com/1194170904115576/myapp/users', $data);
		$arr = json_decode($res, true);
		if (isset($arr['error']))
		{
			return false;
		}
		return true;
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
	function is_authed($cat_id)
	{
		$base_id = session('basemodel.id');
		$cat_ids = session('user.cat_ids');
		$auth_code = $base_id . '_' . $cat_id;
		if (empty($cat_ids))
		{
			return false;
		}
		else
		{
			$auths = explode(',', $cat_ids);
			if (in_array($auth_code, $auths))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * 一维数组转无限级分类树,从id-pid形式转换为id-son形式
	 * @param array $items 数据库中查询出的数据
	 * @return array
	 */
	function genTree5($items)
	{
		foreach ($items as $item)
		{
			$items[$item['pid']]['son'][$item['id']] = &$items[$item['id']];
		}
		return isset($items[0]['son']) ? $items[0]['son'] : array();
	}
	
	/**
	 * 根据经纬度实现两点测距
	 * @param type $lat1
	 * @param type $lon1
	 * @param type $lat2
	 * @param type $lon2
	 * @return type
	 */
	function distance($lat1, $lon1, $lat2, $lon2) {
			$R = 6371393; //地球平均半径,单位米

			$dlat = deg2rad($lat2-$lat1);

			$dlon = deg2rad($lon2-$lon1);

			$a = pow(sin($dlat/2), 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * pow(sin($dlon/2), 2);

			$c = 2 * atan2(sqrt($a), sqrt(1-$a));

			$d = $R * $c;

			return round($d);
	}

	/**
	 * 根据 N 维数组生成Ul树,可用于ajax操作
	 * @param array $data  数据源 使用getTree5即可
	 * @param string $child_flag  作为下级的数组的键
	 * @param string $data_id  生成li后用于绑定数据的字段 如id
	 * @param string $data_name  生成li后用于展示性的字段 如name
	 * 
	 * <li data-id='1'>语文</li>，<li data-id='2'>数学</li>
	 * @param int $deep 允许纵深的最大层级
	 * @return string ul字串
	 */
	function make_ul_tree($data, $child_flag, $data_id, $data_name, $deep)
	{
		$ul_start = "<ul>";
		$li = '';
		if (is_array($data))
		{
			--$deep;
			foreach ($data as $key => $value)
			{
				$plus = '';
				if (array_key_exists($child_flag, $value) && ($deep > 0))
				{
					$plus = make_ul_tree($value[$child_flag], $child_flag, $data_id, $data_name, $deep);
				}
				$li .= "<li data-id='. $value[$data_id] .'>" . $value[$data_name] . $plus . "</li>";
			}
		}
		$ul_end = "</ul>";
		return $ul_start . $li . $ul_end;
	}

	/**
	 * 为4表连接查询拼接sql语句,获取指定范围下指定用户指定分类的待售商品，不填写则为查询全部
	 * @param string $region 'pro' or 'city' or 'area' 三选一,默认为area,即查询当前城市下所有区的产品
	 * @param string $city_id  城市编码
	 * @param string $user_id  用户ID
	 * @param string $cat_id  产品分类ID
	 * @param bool $find_son_cat  是否查询产品子类, 如为true, 则查询产品分类中父ID为cat_id的分类下所有商品
	 * @return string
	 */
	function getGoodsSql($region = 'area', $city_id = '0', $user_id = '0', $cat_id = '0', $find_son_cat = false)
	{
		$sql = "SELECT
				g.*, 
				r.region_name,
  			    u. NAME user_name,
				c. NAME cat_name
			FROM
				foo_goods g
			LEFT JOIN foo_region r ON (g.area = r.region_id)
			LEFT JOIN foo_user u ON (g.user_id = u.id)
			LEFT JOIN foo_category c ON (g.cat_id = c.id)
			WHERE on_sell = 1 ";
		if ($city_id > 0)
		{
			$sql .= "AND g.$region in (SELECT region_id from foo_region where parent_id = $city_id) ";
		}
		if ($user_id > 0)
		{
			$sql .= "AND g.user_id = $user_id ";
		}
		if ($cat_id > 0)
		{
			if ($find_son_cat)
			{
				$sql .= "AND g.cat_id in (SELECT id from foo_category where pid = $cat_id) ";
			}
			else
			{
				$sql .= "AND g.cat_id = $cat_id) ";
			}
		}
		$sql .= "ORDER BY r.region_id ";
		return $sql;
	}
	