<?php
/**
 * @date:  2018/7/24 23:26
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\home\controller;

use app\admin\model\Article as ArticleModel;
use app\admin\model\ArticleLabel;
use app\admin\model\Cat as CatModel;

class Article extends HomeBase {

    protected $beforeActionList = [
        'nav'    => ['only' => 'artshow'],
        'link'   => ['only' => 'artshow'],
        'hotArt' => ['only' => 'artshow'],
    ];

    /**
     * 文章列表
     * @param int $page [当前页数]
     * @param int $list_row [每页条数]
     * @param int $cat_id [栏目id]
     * @param int $label_id [标签id]
     * @param string $title [文章名关键字]
     * @return \think\response\View
     * @throws \think\exception\DbException
     */
    public function artList($page = 1, $list_row = 10, $cat_id = null, $label_id = null, $title = null) {
        $this->getArtList($page, $list_row, $cat_id, $label_id, $title);
        return view();
    }

    public function artShow($art_id) {
        $art_m = new ArticleModel();
        $art = $art_m->getArtById($art_id);
        $cat_m = new CatModel();
        $cat = $cat_m->getCatById($art['cat_id']);
        $art_label_m = new ArticleLabel();
        $art_label = $art_label_m->getLabelNamesByArtId($art_id);
        //dump($art_label);
        $this->assign([
            'art'       => $art,
            'cat'       => $cat,
            'art_label' => $art_label,
            'cat_id'    => $art['cat_id'],
        ]);
        return view('article');
    }
}