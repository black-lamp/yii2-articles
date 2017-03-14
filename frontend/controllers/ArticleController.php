<?php
namespace bl\articles\frontend\controllers;

use bl\articles\common\entities\Article;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ArticleController extends Controller
{
    public function actionIndex($id = null) {
        if(empty($id)) {
            $article = Article::find()->one();
        }
        else {
            $article = Article::findOne($id);
        }

        $articleTranslation = $article->translation;

        $this->view->title = $articleTranslation->seoTitle;
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => html_entity_decode($articleTranslation->seoDescription)
        ]);
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => html_entity_decode($articleTranslation->seoKeywords)
        ]);

        // default view name
        $articleView = 'index';

        if(!empty($article->view)) {
            $articleView = $article->view;
        }
        else if (!empty($article->category)) {
            if(!empty($article->category->article_view)) {
                $articleView = $article->category->article_view;
            }
        }

        $article->updateViewCounter();

        return $this->render($articleView, [
            'article' => $article
        ]);
    }
}