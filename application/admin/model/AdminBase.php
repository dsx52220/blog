<?php
/**
 * @date:  2018/6/24 20:50
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\model;

use app\common\model\BaseModel;

class AdminBase extends BaseModel {
    public function __construct(array $data = []) {
        parent::__construct($data);
    }
}