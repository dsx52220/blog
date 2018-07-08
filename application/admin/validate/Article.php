<?php
/**
 * @since:  2018/6/30 8:32
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\validate;

class Article extends AdminBase {
    protected $rule = [
        'title'     => 'require|length:0,100',
        'author'    => 'require|length:0,10',
        'cat_id'    => 'require|number',
        'label_ids' => 'require|array',
        'img_id'    => 'require|array',
    ];

    protected $message = [

    ];
}