<?php
namespace bl\articles\common\widgets;

use bl\articles\common\entities\Article;
use yii\base\Widget;
use yii\db\Expression;

/**
 * Widget shows Articles.
 *
 * For example:
 * ```php
 * <?= bl\articles\common\widgets\LastArticles::widget([
 *      'count' => 15,
 *      'condition' => [
 *          ['show' => true],
 *          ['<=', 'publish_at', date('Y-m-d')]
 *      ],
 *      'order' => ['updated_at' => SORT_DESC],
 *      'view' => 'last-articles'
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
     * @var string|array|Expression Condition expression.
     */
    public $condition = ['show' => true];

    /**
     * @var string|array|Expression Order expression.
     */
    public $order = ['created_at' => SORT_DESC];

    /**
     * @var string View name.
     */
    public $view = 'last-articles';

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var \yii\db\ActiveQuery $query */
        $query = Article::find()
            ->orderBy($this->order)
            ->limit($this->count);

        if (isset($this->condition[0])) {
            if (is_array($this->condition[0])) {
                foreach ($this->condition as $item) {
                    $query->andWhere($item);
                }
            } else {
                $query->where($this->condition);
            }
        }

        $articles = $query->all();

        return $this->render($this->view, [
            'articles' => $articles
        ]);
    }
}