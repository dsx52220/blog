<?php
/**
 * @since:  2018/6/25 23:33
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\model;

use \app\admin\validate\Article as ArticleValidate;

class Article extends AdminBase {

    protected function getLabelIdsAttr($value) {
        return explode(',', $value);
    }

    protected function setLabelIdsAttr($array) {
        return implode(',', array_unique($array));
    }

    /**
     * 获取文章列表
     * @param int $page [当前页]
     * @param int $list_row [每页条数]
     * @param null $where [筛选条件]
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\exception\DbException
     */
    public function getArtList($page, $list_row, $where = null) {
        $art_list = $this->field('a.*,b.cat_name')->alias('a')->join('cat b', 'a.cat_id=b.id', 'LEFT')->where('a.is_del', 0)->where($where)->order('a.id desc')->limit(($page - 1) * $list_row, $list_row)->select();
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
     * 文章修改
     * @param $art_id [文章id]
     * @param $data [数据数组]
     * @return array|bool|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function artEdit($art_id, $data) {
        $art_v = new ArticleValidate();
        if (!$art_v->check($data)) {
            return $art_v->getError();
        }
        return $this->allowField(true)->save($data, ['id' => $art_id]) || db('article_content')->strict(false)->where(['art_id' => $art_id])->update($data) ? true : '修改失败';
    }

    /**
     * 文章添加
     * @param $data [数据数组]
     * @return array|bool|string
     */
    public function artAdd($data) {
        $art_v = new ArticleValidate();
        if (!$art_v->check($data)) {
            return $art_v->getError();
        }
        $res = $this->allowField(true)->save($data);
        if ($res) {
            $data['art_id'] = $this->id;
            return db('article_content')->strict(false)->insert($data) ? true : '添加内容失败';
        } else {
            return '添加文章失败';
        }
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