<?php
/**
 * @since:  2018/6/25 23:38
 * @author: daishunxin <admin@shunxin66.com>
 */

namespace app\admin\controller;

use app\admin\model\Article as ArticleModel;
use app\admin\model\Cat as CatModel;
use app\admin\model\Label as LabelModel;

class Article extends AdminBase {
    public function artList() {
        $art_m = new ArticleModel();
        $art_list = $art_m->getArtList();
        $page = $art_list->render();
        $this->assign([
            'art_list' => $art_list,
        ]);
        return view();
    }

    public function artEdit($art_id) {
        $art_m = new ArticleModel();
        if (request()->isPost()) {

        } else {
            $art = $art_m->getArtById($art_id);
            $cat_m = new CatModel();
            $cat_list = $cat_m->getCatList();
            $label_m = new LabelModel();
            $label_list = $label_m->getLabelList();
            $this->assign([
                'art'        => $art,
                'cat_list'   => $cat_list,
                'label_list' => $label_list,
            ]);
            //            exit;
            return view();
        }
    }

    public function artAdd() {
        return view();
    }
}