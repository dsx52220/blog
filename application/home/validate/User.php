<?php
/**
 * @date:  2018/8/7 13:47
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\validate;

class User extends HomeBase {
    protected $rule = [
        'username' => 'unique:user',
        'password' => 'length:6,20|alphaDash',
        'email'    => 'require|email',
        'nickname' => 'length:1,20',
    ];

    protected $message = [
        'username.unique'    => '用户名已存在',
        'password.length'    => '密码长度需要6-20个字符',
        'password.alphaDash' => '密码由字母和数字，下划线_ 及破折号-组成',
        'email.require'      => '邮箱不能为空',
        'email.email'        => '邮箱格式不正确',
        'nickname'           => '昵称错误',
    ];
}