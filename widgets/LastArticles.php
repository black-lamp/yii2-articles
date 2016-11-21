<?php
namespace bl\articles\widgets;

use bl\articles\common\entities\Article;
use yii\base\Widget;

/**
 * Widget shows last created Articles.
 *
 * Example:
 * ```php
 * <?= bl\articles\widgets\LastArticles::widget([
 *      'count' => 15
 * ]); ?>
 * ```
 *
 * @author Vyacheslav Nozhenko <vv.nojenko@gmail.com>
 */
class LastArticles extends Widget
{
    /**
     * @var integer Number of articles which will be shown.
     */
    public $count = 10;

    public function run()
    {
        $articles = Article::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($this->count)
            ->all();

        return $this->render('last-articles', [
            'articles' => $articles
        ]);
    }

}