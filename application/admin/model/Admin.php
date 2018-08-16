<?php
/**
 * @date:  2018/6/24 20:48
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\model;

use app\common\model\BaseModel;

class Admin extends BaseModel {

    /**
     * 管理员登录验证
     * @param $username [用户名]
     * @param $password [密码]
     * @return bool|string [true|错误信息]
     * @throws \think\exception\DbException
     */
    public function login($username, $password) {
        if ($admin = Admin::get(['username' => $username])) {
            if (md5($password . $admin->salt) == $admin->password) {
                session('admin', $admin);
                return true;
            } else {
                return '密码错误';
            }
        } else {
            return '用户名不存在';
        }
    }
}