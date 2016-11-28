<?php
namespace bl\articles\common\widgets;

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

    /**
     * @var string|array Condition for query.
     */
    public $condition = null;

    public function run()
    {
        $query = Article::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($this->count);

        if ($this->condition != null) {
            $query->where($this->condition);
        }

        $articles = $query->all();

        return $this->render('last-articles', [
            'articles' => $articles
        ]);
    }

}