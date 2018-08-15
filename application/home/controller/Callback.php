<?php
/**
 * @date:  2018/8/15 13:23
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\controller;

use app\common\model\Common;
use app\home\model\User as UserModel;

class Callback extends HomeBase {
    /**
     * github回调
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function github() {
        if (request()->get('code') && request()->get('state')) {
            $url_access_token = 'https://github.com/login/oauth/access_token';
            $data = [
                'client_id'     => config('github.client_id'),
                'client_secret' => config('github.client_secret'),
                'code'          => request()->get('code'),
                'redirect_uri'  => config('github.callback_url'),
                'state'         => request()->get('state'),
            ];
            $com = new Common();
            $res = $com->postByCurl($url_access_token, null, $data);
            parse_str($res, $res);
            if (isset($res['error'])) {
                $this->error('请求授权失败：' . $res['error']);
            } else {
                $url_user = 'https://api.github.com/user?access_token=' . $res['access_token'];
                $res = $com->getByCurl($url_user, null, null);
                $res = json_decode($res, true);
                $user_m = new UserModel();
                if (!session('user_id')) {  //登录
                    $r = $user_m->loginByGithub($res);
                    if (true === $r) {
                        $this->success('登录成功', '/');
                    } else {
                        $this->error($r);
                    }
                } else {    //绑定账号
                    $user_m->githubBind(session('user_id'), $res) ? $this->success('绑定成功') : $this->error('绑定失败');
                }
            }
        }
        $this->error('登录失败，请重试');
    }
}