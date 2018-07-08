<?php
/**
 * @since:  2018/6/25 23:33
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\model;

class Article extends AdminBase {

    protected function getLabelIdsAttr($value) {
        return explode(',', $value);
    }

    /**
     * 获取文章列表
     * @param int $rows [每页条数]
     * @param null $where [筛选条件]
     * @param string $order [排序条件]
     * @param string $field [获取的列名]
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\exception\DbException
     */
    public function getArtList($page, $list_row, $where = null) {
        $art_list = $this->field('*')->alias('a')->join('cat b', 'a.cat_id=b.id', 'LEFT')->where($where)->order('id desc')->limit(($page - 1) * $list_row, $list_row)->select();
        return $art_list;
    }

    /**
     * 通过id获取文章信息
     * @param $art_id [文章id]
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getArtById($art_id) {
        $art = $this->alias('a')->join('article_content b', 'a.id=b.art_id', 'LEFT')->where('a.id', $art_id)->find();
        return $art;
    }

    /**
     * 获取文章总数
     * @param null $where [筛选条件]
     * @return int|string [文章总数]
     */
    public function getArtTotal($where = null) {
        return $this->where(['is_del' => 0])->where($where)->count(1);
    }
}