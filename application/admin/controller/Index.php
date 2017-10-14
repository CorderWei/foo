<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Index extends Controller
{
	
	// 首页
    public function index()
    {
		$menu = getMenuArr();
		$this->assign('menu',$menu);
		return $this->fetch();
    }
	
}
