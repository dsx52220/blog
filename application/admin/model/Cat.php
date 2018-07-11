<?php
/**
 * @since:  2018/6/27 23:35
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\model;

use \app\admin\validate\Cat as CatValidate;

class Cat extends AdminBase {
    /**
     * 获取栏目列表
     * @param int page [当前页数]
     * @param int $list_row [每页条数]
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCatList($page = null, $list_row = null) {
        $cat_m = $this;
        if (isset($page) && isset($list_row)) {
            $cat_m = $cat_m->limit(($page - 1) * $list_row, $list_row);
        }
        $cat_list = $cat_m->where(['is_del' => 0])->order('order')->select();
        return $cat_list;
    }

    /**
     * 获取栏目总数
     * @return int|string
     */
    public function getCatTotal() {
        return $this->where(['is_del' => 0])->count(1);
    }

    /**
     * 根据栏目id获取信息
     * @param $cat_id [栏目id]
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCatById($cat_id) {
        return $this->where(['is_del' => 0])->find($cat_id);
    }

    /**
     * 添加栏目
     * @param $data [栏目数据]
     * @return array|bool|string
     */
    public function catAdd($data) {
        $cat_v = new CatValidate();
        if (!$cat_v->check($data)) {
            return $cat_v->getError();
        } else {
            return $this->save($data) ? true : '添加失败';
        }
    }

    /**
     * 栏目修改
     * @param $cat_id [栏目id]
     * @param $data [修改数据]
     * @return array|bool|string
     */
    public function catEdit($cat_id, $data) {
        $cat_v = new CatValidate();
        if (!$cat_v->check($data)) {
            return $cat_v->getError();
        }
        return $this->where(['id' => $cat_id, 'is_del' => 0,])->update($data) ? true : '保存失败，可能未进行任何修改!';
    }

    /**
     * 栏目删除
     * @param $cat_id [栏目id]
     * @return bool|string
     */
    public function catDel($cat_id) {
        return $this->where(['id' => $cat_id])->update(['is_del' => 1]) ? true : '删除失败';
    }
}