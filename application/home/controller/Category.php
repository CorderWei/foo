<?php
namespace app\home\controller;
use think\Controller;
use think\Request;
use think\Db;
class Category extends Controller
{
	 public function index()
    {
		return $this->fetch();
    }
}
