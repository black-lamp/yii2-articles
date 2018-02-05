<?php
use bl\articles\common\entities\Article;
use yii\helpers\Url;
use yii\web\View;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 * @var View $this
 * @var Article $article
 */

?>

<section class="article-mini">
    <div class="row">
        <div class="col-xs-4">
            <a class="image" href="<?= Url::to(['/articles/article/index', 'id' => $article->id]) ?>"
               style="background-image: url(<?= $article->thumbnail ? '/images/articles/thumbnail/' . $article->thumbnail . '-big.jpg' : '/img/default.jpg'; ?>)">
            </a>
        </div>
        <div class="col-xs-8">
            <div class="content">
                <a href="<?= Url::to(['/articles/article/index', 'id' => $article->id]) ?>" class="title">
                    <h3 class="article-title">
                        <?= $article->translation->name ?>
                    </h3>
                </a>
                <div class="text">
                    <?= strip_tags($article->translation->short_text) ?>
                </div>
            </div>
            <div class="control">
                <a href="<?= Url::to(['/articles/article/index', 'id' => $article->id]) ?>"
                   class="btn btn-primary btn-i pull-right">
                    Читати повністю >>
                </a>
            </div>
        </div>
    </div>
</section>