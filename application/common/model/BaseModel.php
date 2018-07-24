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

    /**
     * 获取一个唯一字符串
     * @return string
     */
    public function uniqueStr() {
        $str = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM!@#$%^&*()-=_+';
        return time() . substr(str_shuffle($str), 0, 6);
    }

    public function isDir($dir) {
        if (is_dir($dir)) {
            return true;
        } else {
            if (mkdir($dir, '0777', true)) {
                return true;
            } else {
                return false;
            }
        }
    }
}