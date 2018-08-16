<?php
return [
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl' => THINK_PATH . 'tpl' . DS . 'layui_jump.tpl',
    'dispatch_error_tmpl'   => THINK_PATH . 'tpl' . DS . 'layui_jump.tpl',

    //github登录配置
    'github'                => [
        'client_id'     => '你的client_id',
        'client_secret' => '你的client_secret',
        'callback_url'  => 'http://你的域名/home/callback/github',
    ],

    //qq互联登录配置
    'qq'                    => [
        'app_id'       => '你的appID',
        'app_key'      => '你的appKey',
        'callback_url' => 'http://你的域名/home/callback/qq',
    ],

    //cookie加密盐
    'cookie_salt'           => 'haha',
];