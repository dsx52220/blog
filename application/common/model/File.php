<?php
/**
 * @date:  2018/10/20 19:59
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\common\model;

class File {

    /**
     * 获取文件夹下内容
     * @param string $path [文件夹路径]
     * @param array $ext [需要显示的文件后缀名,null:显示所有文件和文件夹]
     * @param bool $isShowUpperDir [是否显示上一级文件夹]
     * @return array [文件夹下内容]
     */
    public function getPathContent($path, $ext = null, $isShowUpperDir = true) {
        $path_content = [];
        if (is_dir($path)) {
            $dir = opendir($path);
            while ($item = readdir($dir)) {
                $arr = explode('.', $item);
                if (is_file($path . $item) && (!isset($ext) || in_array('.' . end($arr), $ext))) {
                    $finfo = finfo_open(FILEINFO_MIME);
                    $mimetype = finfo_file($finfo, $path . $item);
                    finfo_close($finfo);
                    $path_content[] = [
                        'name' => $item,
                        'path' => strchr($path . $item, '/static/'),
                        'time' => date('Y-m-d H:i:s', filemtime($path . $item)),
                        'type' => $mimetype,
                    ];
                } else if (is_dir($path . $item) && $item != '.') {
                    if (!$isShowUpperDir && $item == '..') {
                        continue;
                    }
                    $path_content[] = [
                        'name' => $item,
                        'path' => strchr($item == '..' ? dirname($path) . '/' : "$path$item/", '/static/'),
                        'time' => date('Y-m-d H:i:s', filemtime($path . $item)),
                        'type' => 'dir',
                    ];
                }
            }
            closedir($dir);
        }
        return $path_content;
    }
}