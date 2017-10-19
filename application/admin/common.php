<?php

	function getMenuArr()
	{
		$menuArr = include APP_PATH . 'admin/conf/menu.php';
		$act_list = session('act_list');
		if ($act_list != 'all' && !empty($act_list))
		{

			foreach ($menuArr as $k => $val)
			{
				foreach ($val['child'] as $j => $v)
				{
					foreach ($v['child'] as $s => $son)
					{
						if (!strpos($role_right, $son['op'] . 'Controller@' . $son['act']))
						{
							unset($menuArr[$k]['child'][$j]['child'][$s]); //过滤菜单
						}
					}
				}
			}

			foreach ($menuArr as $mk => $mr)
			{
				foreach ($mr['child'] as $nk => $nrr)
				{
					if (empty($nrr['child']))
					{
						unset($menuArr[$mk]['child'][$nk]);
					}
				}
			}
		}
		return $menuArr;
	}
	
	function getMenuArr2(){
		$menuArr = include APP_PATH . 'admin/conf/menu.php';
		return $menuArr;
	}
	
	function getAuthList($table_name){
		$sql = "SELECT 
					t.*, 
					c. NAME
				FROM
					foo_$table_name t
				LEFT JOIN foo_category c ON (c.id = t.cat_id)
				WHERE
					1 = 1";
		return $sql;
	}
	
	/**
	 * 更改权限列表中的字串
	 * @param string $auth_code 要新增或者删除的权限字串,即待验证字串, 如【5_0】;
	 * @param string $old_auth 原有的权限集合，如【1_1,2_3,5_0】
	 * @return string
	 */
	function change_auth($auth_code,$old_auth)
	{
		if (empty($old_auth))
		{
			//原集合中无字串, 则新增
			$new_auth = $auth_code;
		}
		else
		{
			//原集合中无待验证字串, 则新增
			$old_auth_arr = explode(',', $old_auth);
			$new_auth_arr = [];
			if (!in_array($auth_code, $old_auth_arr))
			{
				$old_auth_arr[] = $auth_code;
				$new_auth = implode(',', $old_auth_arr);
			}
			//原码中有待验证字串, 则删除
			else
			{
				$key = array_search($auth_code, $old_auth_arr);
				if(isset($key))
				{
					unset($old_auth_arr[$key]);
					$new_auth_arr = $old_auth_arr;
				}
				$new_auth = implode(',', $new_auth_arr);
			}
		}
		return $new_auth;
	}
	