<?php
namespace app\home\validate;
use think\Validate;
/*
 * 调用自动验证
 * 
 */
class Index extends Validate{
    
    //需要验证的键值
    protected $rule =   [
		//'code'               => 'require|number|length:6',    //验证码 必填 整数 长度是6位
        'name'               => 'require|unique:user',
        'pass'           => 'require|length:6,20',
        'pass2'          => 'require|confirm:pass',  //必填。验证字段和password字段的值相等
    ];
    //验证不符返回msg
    protected $message  =   [
//        'code.require'      => '验证码必填',    
//        'code.number'       => '验证码格式为数字',
//        'code.length'       =>'验证码格式为6位的数字',
        'name.require' => '用户名必填',
        'name.unique' => '用户名已存在',
        'pass.require'       => '密码必填',
        'pass.length'       => '密码应在6-20之间',
        'pass2.require'   => '确认密码必填',
        'pass2.confirm'   => '确认密码与密码内容不一致',        

    ];
    //需要指定验证位置 和字段
    protected $scene = [
        'doregister'                 =>  ['name','pass','pass2'],
    ];

}