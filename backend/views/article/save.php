<?php
use bl\articles\backend\assets\TabsAsset;
use bl\articles\backend\components\form\ArticleImageForm;
use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\common\entities\Category;
use bl\multilang\entities\Language;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var $image_form ArticleImageForm
 * @var $languages Language[]
 * @var $selectedLanguage Language
 * @var $article Article
 * @var $article_translation ArticleTranslation
 * @var $categories Category[]
 */

$this->title = Yii::t('articles', 'Save article');

TabsAsset::register($this);
?>

<ul class="tabs">
    <li>
        <?=Html::a(Yii::t('articles', 'Basic'), Url::to(['add-basic',  'articleId' => $article->id, 'languageId' => $languageId]), ['class' => 'image']);?>
    </li>
    <li>
        <?=Html::a(Yii::t('articles', 'Images'), Url::to(['add-images',  'articleId' => $article->id, 'languageId' => $languageId]), ['class' => 'image']);?>
    </li>
</ul>


<?php Pjax::begin([
    'linkSelector' => '.image',
    'enablePushState' => true,
    'timeout' => 10000
]);
?>

<?= $this->render($viewName, $params);
?>
<? Pjax::end(); ?>