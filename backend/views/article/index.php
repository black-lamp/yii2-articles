<?php
use bl\articles\common\entities\Article;
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * @var $languages Language[]
 * @var $articles Article[]
 *
 */

$this->title = Yii::t('articles', 'Articles');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-list"></i>
                <?= Yii::t('articles', 'Articles list') ?>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <?php if (!empty($articles)): ?>
                        <thead>
                        <tr>
                            <th class="col-lg-1"><?= Yii::t('articles', 'Position'); ?></th>
                            <th class="col-lg-3"><?= Yii::t('articles', 'Title'); ?></th>
                            <th class="col-lg-3"><?= Yii::t('articles', 'Category'); ?></th>
                            <th class="col-lg-3"><?= Yii::t('articles', 'Description'); ?></th>
                            <?php if(count($languages) > 1): ?>
                                <th class="col-lg-3"><?= Yii::t('articles', 'Language'); ?></th>
                            <?php endif; ?>
                            <th><?= Yii::t('articles', 'Show'); ?></th>
                            <th><?= Yii::t('articles', 'Publish date'); ?></th>
                            <th><?= Yii::t('articles', 'Edit'); ?></th>
                            <th><?= Yii::t('articles', 'Delete'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td class="text-center">
                                    <?= $article->position ?>
                                    <a href="<?= Url::to([
                                        'up',
                                        'id' => $article->id
                                    ]) ?>" class="glyphicon glyphicon-arrow-up text-primary pull-left">
                                    </a>
                                    <a href="<?= Url::to([
                                        'down',
                                        'id' => $article->id
                                    ]) ?>" class="glyphicon glyphicon-arrow-down text-primary pull-left">
                                    </a>
                                </td>

                                <td>
                                    <?= Html::a($article->translation->name, ['/articles/article/save',
                                        'articleId' => $article->id,
                                        'languageId' => Language::getCurrent()->id
                                    ]) ?>
                                </td>


                                <td>
                                    <?php if(!empty($article->category)): ?>
                                        <?= Html::a($article->category->translation->name, ['/articles/category/save',
                                            'categoryId' => $article->category->id,
                                            'languageId' => Language::getCurrent()->id
                                        ]) ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= StringHelper::truncate(strip_tags($article->translation->short_text), 30, '...') ?>
                                </td>

                                <td>
                                    <?php if(count($languages) > 1): ?>
                                        <?php $translations = ArrayHelper::index($article->translations, 'language_id') ?>  
                                        <?php foreach ($languages as $language): ?>
                                            <a href="<?= Url::to([
                                                'save',
                                                'articleId' => $article->id,
                                                'languageId' => $language->id
                                            ]) ?>"
                                               type="button"
                                               class="btn btn-<?= !empty($translations[$language->id]) ? 'primary' : 'danger'
                                               ?> btn-xs"><?= $language->name ?></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= Url::to([
                                        'switch-show',
                                        'id' => $article->id
                                    ]) ?>">
                                        <?php if ($article->show): ?>
                                            <i class="glyphicon glyphicon-ok text-primary"></i>
                                        <?php else: ?>
                                            <i class="glyphicon glyphicon-minus text-danger"></i>
                                        <?php endif; ?>
                                    </a>
                                </td>

                                <td><?= $article->publish_at; ?></td>

                                <td>
                                    <a href="<?= Url::to([
                                        'save',
                                        'articleId' => $article->id,
                                        'languageId' => (!empty($article->translation->language->id)) ? $article->translation->language->id : Language::getCurrent()->id
                                    ])?>" class="glyphicon glyphicon-edit text-warning btn btn-default btn-sm">
                                    </a>
                                </td>

                                <td>
                                    <a href="<?= Url::to([
                                        'remove',
                                        'id' => $article->id
                                    ])?>" class="glyphicon glyphicon-remove text-danger btn btn-default btn-sm">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    <?php endif; ?>
                </table>
                <!-- TODO: languageId -->
                <a href="<?= Url::to(['/articles/article/save', 'languageId' => Language::getCurrent()->id]) ?>"
                   class="btn btn-primary pull-right">
                    <i class="fa fa-user-plus"></i> <?= Yii::t('articles', 'Add'); ?>
                </a>
            </div>
        </div>
    </div>
</div>


