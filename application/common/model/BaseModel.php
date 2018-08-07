<?php
/**
 * 公共基础模型类
 * @date:  2018/6/24 20:33
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\common\model;

use think\Model;

class BaseModel extends Model {
    protected $autoWriteTimestamp = true;
    protected $createTime = 'add_time';
    protected $updateTime = 'update_time';

    public function __construct($data = []) {
        parent::__construct($data);
    }
}