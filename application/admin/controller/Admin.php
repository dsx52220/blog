<?php
/**
 * @since:  2018/6/7 23:32
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\controller;

use \app\admin\model\Admin as AdminModel;

class Admin extends AdminBase {
    /**
     * 管理员登录
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function login() {
        if (request()->isAjax()) {
            if ($this->checkCaptcha(request()->post('captcha'))) {
                $admin_m = new AdminModel();
                $res = $admin_m->login(request()->post('username'), request()->post('password'));
                if ($res === true) {
                    $this->success('登录成功', url('layout', null, true, true));
                } else {
                    $this->error($res);
                }
            } else {
                $this->error('验证码错误');
            }
        } else {
            return view();
        }
    }

    /**
     * 管理员注销登录
     */
    public function logout() {
        session('admin', null);
        $this->success('注销成功', url('login', null, true, true));
    }

    /**
     * 后台主框架
     * @return \think\response\View
     */
    public function layout() {
        return view();
    }

    /**
     * 后台首页
     * @return \think\response\View
     */
    public function index() {
        return view();
    }
}