<?php
use bl\articles\common\entities\Article;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author Vyacheslav Nozhenko <vv.nojenko@gmail.com>
 *
 * @var \yii\web\View $this
 * @var Article[] $articles
 */


?>

<table class="table-hover table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th class="col-md-1 text-center"><?= Yii::t('articles', 'Image'); ?></th>
            <th><?= Yii::t('articles', 'Title'); ?></th>
            <th><?= Yii::t('articles', 'Category'); ?></th>
            <th class="col-md-2"><?= Yii::t('articles', 'Created'); ?></th>
            <th class="col-md-2"><?= Yii::t('articles', 'Publish date'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5" class="text-center small">
                <?= Html::a('<i class="fa fa-plus m-r-xs"></i>' . Yii::t('articles', 'Add'), [
                    '/articles/article/save', 'languageId' => Language::getCurrent()->id
                ]) ?>
            </td>
        </tr>
        <?php foreach ($articles as $article) : ?>
            <tr>
                <td class="text-center" style="padding: 5px;">
                    <a href="<?= Url::to(['/articles/article/add-images', 'articleId' => $article->id, 'languageId' => Language::getCurrent()->id]); ?>">
                        <?php if (!empty($article->thumbnail)): ?>
                            <div class="center-block" style="background-image: url(<?= $article->getImage('thumbnail', 'small') ?>);
                                background-size: cover; background-position: center;
                                width: 64px; height: 64px; ">
                            </div>
                        <?php else: ?>
                            <i class="fa fa-picture-o text-muted m-t-xs"></i>
                        <?php endif; ?>
                    </a>
                </td>
                <td>
                    <?= Html::a($article->translation->name, ['/articles/article/save',
                        'articleId' => $article->id, 'languageId' => Language::getCurrent()->id
                    ]); ?>
                </td>
                <td>
                    <?php if(!empty($article->category->translation->name)): ?>
                        <?= Html::a($article->category->translation->name, [
                            '/articles/category/save',
                            'categoryId' => $article->category_id, 'languageId' => Language::getCurrent()->id
                        ]); ?>
                    <?php else: ?>
                        <span><?= Yii::t('articles', 'Without category') ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?= Yii::$app->formatter->asRelativeTime($article->created_at); ?>
                </td>
                <td>
                    <?= Yii::$app->formatter->asDatetime($article->publish_at); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>