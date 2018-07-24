<?php
/**
 * 前台基础控制器
 * @date:  2018/6/7 23:09
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\controller;

use app\common\controller\BaseController;
use think\Request;

class HomeBase extends BaseController {
    public function __construct(Request $request = null) {
        parent::__construct($request);
    }

}