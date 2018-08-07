<?php
/**
 * @date:  2018/8/7 13:31
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\controller;

use app\common\model\AliYun;
use app\common\model\Common;
use \app\home\validate\User as UserValidate;

class User extends HomeBase {
    public function login() {
        if (request()->isPost()) {

        } else {
            return view();
        }
    }

    public function register() {
        if (request()->isPost()) {

        } else {
            return view();
        }
    }

    /**
     * 获取注册验证码
     */
    public function getRegEmailCode() {
        $user_v = new UserValidate();
        if (!$user_v->check(request()->post())) {   //验证用户提交数据是否合规
            $this->error($user_v->getError());
        } else if (!$this->checkCaptcha(request()->post('captcha'))) {  //验证验证码是否哦填写正确
            $this->error('验证码错误');
        } else {
            $com = new Common();
            //获取随机数字验证码
            $captcha = $com->getNumCaptcha();
            $html_body = '您的验证码为：' . $captcha . '，5分钟内有效';
            //发送邮件验证码
            $res = (new AliYun())->sendEmail('注册验证码', request()->post('email'), '博客注册验证码', $html_body);
            if (true === $res) {
                //加密注册邮件验证码并存储到cookie
                cookie('reg_code', $com->encrypt($captcha, config('cookie_salt')), 5 * 60);
                $this->success('验证码发送成功');
            } else {
                $this->error('验证码发送失败，请重试');
            }
        }
    }
}