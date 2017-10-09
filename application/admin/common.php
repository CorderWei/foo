<?php

function getMenuArr(){
	$menuArr = include APP_PATH.'admin/conf/menu.php';
	$act_list = session('act_list');
	if($act_list != 'all' && !empty($act_list)){
//		$right = M('system_menu')->where("id in ($act_list)")->cache(true)->getField('right',true);
//		foreach ($right as $val){
//			$role_right .= $val.',';
//		}
			
		foreach($menuArr as $k=>$val){
			foreach ($val['child'] as $j=>$v){
				foreach ($v['child'] as $s=>$son){
					if(!strpos($role_right,$son['op'].'Controller@'.$son['act'])){
						unset($menuArr[$k]['child'][$j]['child'][$s]);//过滤菜单
					}
				}
			}
		}
	
		foreach ($menuArr as $mk=>$mr){
			foreach ($mr['child'] as $nk=>$nrr){
				if(empty($nrr['child'])){
					unset($menuArr[$mk]['child'][$nk]);
				}
			}
		}
	}
	return $menuArr;
}
