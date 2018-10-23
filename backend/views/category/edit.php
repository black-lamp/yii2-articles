<?php

use bl\articles\common\entities\Category;
use bl\articles\common\entities\CategoryTranslation;
use dosamigos\tinymce\TinyMce;
use bl\multilang\entities\Language;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $category Category */
/* @var $category_translation CategoryTranslation */
/* @var $languages Language[] */
/* @var $selectedLanguage Language */
/* @var $categories Category[] */

$this->title = Yii::t('articles', 'Category');
?>

<?php $form = ActiveForm::begin([
    'action' => Url::to(['/articles/category/save',
        'categoryId' => $category->id,
        'languageId' => $selectedLanguage->id
    ]),
    'method' => 'post'
]); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-list"></i>
                    <?= Yii::t('articles', 'Category'); ?>
                </div>
                <div class="panel-body">
                    <?php if (count($languages) > 1): ?>
                        <div class="dropdown">
                            <button class="btn btn-warning btn-xs dropdown-toggle" type="button" id="dropdownMenu1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?= $selectedLanguage->name ?>
                                <span class="caret"></span>
                            </button>
                            <?php if (count($languages) > 1): ?>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php foreach ($languages as $language): ?>
                                        <li>
                                            <a href="
                                            <?= Url::to([
                                                'save',
                                                'categoryId' => $category->id,
                                                'languageId' => $language->id]) ?>
                                            ">
                                                <?= $language->name ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group field-toolscategoryform-parent has-success">
                        <label class="control-label"
                               for="toolscategoryform-parent"><?= Yii::t('articles', 'Parent category'); ?></label>
                        <select id="category-parent_id" class="form-control" name="Category[parent_id]">
                            <option value="">-- <?= Yii::t('articles', 'Not selected'); ?> --</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option <?= $category->parent_id == $cat->id ? 'selected' : '' ?>
                                            value="<?= $cat->id ?>">
                                        <?= $cat->translation->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="help-block"></div>
                    </div>
                    <?= $form->field($category_translation, 'name', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('articles', 'Name'));
                    ?>

                    <?= $form->field($category, 'color', [
                        'inputOptions' => [
                            'class' => 'form-control',
                            'type' => 'color'
                        ]
                    ])->label(Yii::t('articles', 'Color'));
                    ?>

                    <?= $form->field($category_translation, 'short_text', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'ru',
                        'clientOptions' => [
                            'plugins' => [
                                'textcolor colorpicker',
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste",
                                'image'
                            ],
                            'toolbar' => "undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                            'images_upload_url' => Url::to(['article/upload-image'])
                        ]
                    ])->label(Yii::t('articles', 'Short description'));
                    ?>
                    <?= $form->field($category_translation, 'text', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->widget(TinyMce::className(), [
                        'options' => ['rows' => 20],
                        'language' => 'ru',
                        'clientOptions' => [
                            'plugins' => [
                                'textcolor colorpicker',
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste",
                                'image'
                            ],
                            'toolbar' => "undo redo | forecolor backcolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                            'images_upload_url' => Url::to(['article/upload-image'])
                        ]
                    ])->label(Yii::t('articles', 'Full description'));
                    ?>
                    <input type="submit" class="btn btn-primary pull-right" value="<?= Yii::t('articles', 'Save'); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-list"></i>
                    <?= Yii::t('articles', 'Seo Data'); ?>
                </div>
                <div class="panel-body">
                    <?= $form->field($category_translation, 'seoUrl', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('articles', 'Seo Url'));
                    ?>

                    <?= $form->field($category_translation, 'seoTitle', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('articles', 'Seo Title'));
                    ?>

                    <?= $form->field($category_translation, 'seoDescription', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->textarea(['rows' => 3])->label(Yii::t('articles', 'Seo Description'));
                    ?>

                    <?= $form->field($category_translation, 'seoKeywords', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->textarea(['rows' => 3])->label(Yii::t('articles', 'Seo Keywords'));
                    ?>
                    <input type="submit" class="btn btn-primary pull-right" value="<?= Yii::t('articles', 'Save'); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-list"></i>
                    <?= Yii::t('articles', 'Tech'); ?>
                </div>
                <div class="panel-body">
                    <?= $form->field($category, 'view', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('articles', 'View name'));
                    ?>
                    <?= $form->field($category, 'article_view', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('articles', 'Articles view name'));
                    ?>
                    <?= $form->field($category, 'key', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->label(Yii::t('articles', 'Key'));
                    ?>

                    <?= $form->field($category, 'show', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->checkbox([
                        'label' => Yii::t('articles', 'Show')
                    ]);
                    ?>
                    <?= $form->field($category, 'show_articles', [
                        'inputOptions' => [
                            'class' => 'form-control'
                        ]
                    ])->checkbox([
                        'label' => Yii::t('articles', 'Show articles')
                    ]);
                    ?>
                    <input type="submit" class="btn btn-primary pull-right" value="<?= Yii::t('articles', 'Save'); ?>">
                </div>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>