<?php
namespace bl\articles\frontend\controllers;

use bl\articles\common\entities\Category;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CategoryController extends Controller
{
    public function actionIndex($id) {
        /* @var Category $category */
        $category = Category::findOne($id);

        $categoryTranslation = $category->translation;

        if(!empty($categoryTranslation->seoTitle)) {
            $this->view->title = $categoryTranslation->seoTitle;
        }
        else {
            $this->view->title = $categoryTranslation->name;
        }
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => html_entity_decode($categoryTranslation->seoDescription)
        ]);
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => html_entity_decode($categoryTranslation->seoKeywords)
        ]);
        $this->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Url::to([
                '/articles/category/index',
                'id' => $category->id
            ])
        ]);

        return $this->render(!empty($category->view) ? $category->view : 'index', [
            'category' => $category
        ]);
    }
}