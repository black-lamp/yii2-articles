<?php
namespace bl\articles\frontend\controllers;

use bl\articles\common\entities\Article;
use bl\articles\frontend\Module as FrontendModule;
use yii\helpers\Url;
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
        if (!empty($articleTranslation->name)) {
            $this->view->registerMetaTag([
                'property' => 'og:title',
                'content' => html_entity_decode($articleTranslation->name)
            ]);
        }
        if (!empty($articleTranslation->short_text)) {
            $this->view->registerMetaTag([
                'property' => 'og:description',
                'content' => strip_tags(html_entity_decode($articleTranslation->short_text))
            ]);
        }
        if (!empty(\Yii::$app->params['siteName'])) {
            $this->view->registerMetaTag([
                'property' => 'og:site_name',
                'content' => html_entity_decode(\Yii::$app->params['siteName'])
            ]);
        }
        if (!empty($article->thumbnail)) {
            $this->view->registerMetaTag([
                'property' => 'og:image',
                'content' => html_entity_decode(Url::to($article->thumbnail ? '/images/articles/thumbnail/' . $article->thumbnail . '-origin.jpg' : '/img/default.jpg', true))
            ]);
            $this->view->registerMetaTag([
                'property' => 'og:image:secure_url',
                'content' => html_entity_decode(Url::to($article->thumbnail ? '/images/articles/thumbnail/' . $article->thumbnail . '-origin.jpg' : '/img/default.jpg', true))
            ]);
        }
        $this->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Url::to([
                '/articles/article/index',
                'id' => $article->id
            ], true)
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

        if ($this->module->params[FrontendModule::COUNT_VIEWS_PARAM]) {
            $article->updateViewCounter();
        }

        return $this->render($articleView, [
            'article' => $article
        ]);
    }
}
