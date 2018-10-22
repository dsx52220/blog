<?php
/**
 * @date:  2018/10/20 23:08
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\controller;

use app\common\model\File as FileModel;
use think\exception\ErrorException;


class File extends AdminBase {

    /**
     * 图片路径内容展示
     * @param string $path [图片路径]
     * @return \think\response\View
     */
    public function showImgPath($path = null) {
        $full_path = ROOT_PATH . 'public' . preg_replace('/\.\.\/.*\//', '', $path);
        $img_root_path = ROOT_PATH . 'public' . config('UEditor.imageManagerListPath');
        if (!isset($path) || !is_dir($full_path)) {
            //图片上传目录
            $full_path = $img_root_path;
        }
        //需展示的图片扩展名
        $ext = config('UEditor.imageManagerAllowFiles');
        $file_m = new FileModel();
        $path_items = $file_m->getPathContent($full_path, $ext, dirname($full_path) != dirname($img_root_path));
        $this->assign([
            'curr_path'  => ltrim(strchr($full_path, '/image/'), '/image/'),
            'path_items' => $path_items,
            'url'        => $_SERVER['REQUEST_URI'],
        ]);
        return view('show_img_path');
    }

    public function imgUpload() {

    }

    /**
     * 新建文件夹
     */
    public function mkFolder() {
        $full_folder_name = ROOT_PATH . 'public/static/upload/' . ltrim(request()->post('folder_name'), '/');
        if (is_dir($full_folder_name)) {
            $this->error('该文件夹已存在，无法重复创建');
        } else {
            mkdir($full_folder_name, 0777, true) ? $this->success('新建文件夹成功') : $this->error('新建文件夹失败');
        }
    }

    /**
     * 删除文件或文件夹
     */
    public function rmPath() {
        $full_path_name = ROOT_PATH . 'public/static/upload/' . ltrim(request()->post('path'), '/');
        if (is_dir($full_path_name)) {
            try {
                rmdir($full_path_name) ? $this->success('删除文件夹成功') : $this->error('删除文件夹失败');
            } catch (ErrorException $e) {
                $this->error('删除失败，可能该文件夹不为空');
            }
        } else if (is_file($full_path_name)) {
            unlink($full_path_name) ? $this->success('删除文件成功') : $this->error('删除文件失败');
        } else {
            $this->error('所选路径不存在，请刷新后重试！');
        }
    }
}