<?php
/**
 * @date:  2018/8/7 13:44
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\model;

use app\common\model\AliYun;
use app\common\model\Common;
use \app\home\validate\User as UserValidate;
use think\exception\DbException;

class User extends HomeBase {
    private $head_img_path = '/static/images/head';

    /**
     * 邮箱登录
     * @param $email [邮箱]
     * @param $captcha [邮件验证码]
     * @return array|bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginByEmail($email, $captcha) {
        $com = new Common();
        if (!cookie('login_email') || !cookie('login_code')) {
            return '邮件验证码已过期，请重新获取';
        } else if (cookie('login_email') != $com->cookieEncrypt($email)) {
            return '邮箱错误';
        } else if (cookie('login_code') != $com->cookieEncrypt($captcha)) {
            return '邮件验证码错误';
        } else {
            $user = $this->where('email', $email)->find();
            if (!$user) { //不存在，则注册
                $password = $com->getRandomNum(6);  //明文密码
                $data['email'] = $email;
                $data['salt'] = $com->getRandomStr(4);
                $data['password'] = $com->encrypt($password, $data['salt']);
                $data['head_img'] = $this->head_img_path . '/' . rand(1, 10) . '.svg';
                $res = $this->userAdd($data);
                if (true === $res) {
                    cookie(null, 'login_');
                    (new AliYun())->sendEmail('初始密码', $email, '博客初始密码', '您的博客初始密码为：' . $password);
                    session('user_id', $this->id);
                    session('nickname', $this->nickname);
                    session('head_img', $this->head_img);
                }
                return $res;
            } else {
                session('user_id', $user['id']);
                session('nickname', $user['nickname']);
                session('head_img', $user['head_img']);
                return true;
            }
        }
    }

    /**
     * 密码登录
     * @param $username [用户名或邮箱]
     * @param $password [密码]
     * @return bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginByPwd($username, $password) {
        $user = $this->where('username', $username)->whereOr('email', $username)->find();
        if (!$user) {
            return '用户名或邮箱不存在';
        } else if ($user->password != (new Common())->encrypt($password, $user->salt)) {
            return '密码错误';
        } else {
            session('user_id', $user->id);
            session('nickname', $user->nickname);
            session('head_img', $user->head_img);
            return true;
        }
    }

    /**
     * github账号登录
     * @param $github_data
     * @return array|bool|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function loginByGithub($github_data) {
        $user = $this->where(['github_id' => $github_data['id']])->find();
        if (!$user) { //不存在则自动注册
            $data = [
                'github_id'         => $github_data['id'],
                'github_login'      => $github_data['login'],
                'github_name'       => $github_data['name'],
                'github_avatar_url' => $github_data['avatar_url'],
                'nickname'          => $github_data['name'],
                'head_img'          => $github_data['avatar_url'],
            ];
            $res = $this->userAdd($data);
            if (true === $res) {
                session('user_id', $this->id);
                session('nickname', $this->nickname);
                session('head_img', $this->head_img);
            }
            return $res;
        } else {
            session('user_id', $user['id']);
            session('nickname', $user['nickname']);
            session('head_img', $user['head_img']);
            return true;
        }
    }

    /**
     * 绑定账号
     * @param $user_id [用户id]
     * @param $github_data [github账号信息]
     * @return false|int|string
     */
    public function githubBind($user_id, $github_data) {
        $data = [
            'github_id'         => $github_data['id'],
            'github_login'      => $github_data['login'],
            'github_name'       => $github_data['name'],
            'github_avatar_url' => $github_data['avatar_url'],
        ];
        try {
            return $this->where('id', $user_id)->data($data)->save();
        } catch (DbException $e) {
            return '绑定失败';
        }
    }

    /**
     * 添加用户
     * @param $data
     * @return array|bool|string
     */
    public function userAdd($data) {
        $user_v = new UserValidate();
        if (!$user_v->check($data)) {
            return $user_v->getError();
        } else {
            return $this->save($data) ? true : '添加失败';
        }
    }
}