<?php
namespace bl\articles\frontend\widgets;

use bl\articles\common\entities\Article;
use bl\articles\common\entities\Category;
use yii\base\Widget;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class ArticleList extends Widget
{
    public $articles = [];
    public $categoryKey = 'news';
    public $title = '';
    public $slider = false;

    public function run()
    {
        if(!empty($this->categoryKey) && empty($this->articles)) {
            $category = Category::findOne(['key' => $this->categoryKey]);
            if(!empty($category)) {
                if(empty($this->title)) {
                    $this->title = $category->translation->name;
                }
                $articles = Article::find()
                    ->joinWith('category')
                    ->where([
                        'article_category.id' => $category->id
                    ])
                    ->orderBy('position')->all();

                if(!empty($articles)) {
                    $this->articles = $articles;
                }
            }
        }

        $result = $this->render('article-list', [
            'articles' => $this->articles,
            'title' => $this->title,
            'slider' => $this->slider,
        ]);

        return $result;
    }
}