<?php
/**
 * @date:  2018/7/24 23:26
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\controller;

class Article extends HomeBase {
    public function artShow() {
        return view('article');
    }
}