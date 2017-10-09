<?php
namespace app\home\controller;
use think\Controller;
use think\Request;
use think\Db;
class Index extends Controller
{
    public function index()
    {
		return $this->fetch();
    }
	// 登录
	public function login()
    {
		return $this->fetch();
    }
	// 执行登录
	public function dologin()
    {
		
		//登录成功
		if(true){
			$this->redirect('index');
		}else{
			$this->redirect('login');
		}
    }
	// 注册
	public function register()
    {
		return $this->fetch();
    }
	// 执行注册
	public function doregister()
    {
		//注册成功
		if(true){
			$this->redirect('login');
		}else{
			$this->redirect('register');
		}
    }
	// 退出登录
	public function logout(){
		
	}
}
