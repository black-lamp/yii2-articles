<?php
namespace bl\articles\common\entities;

use bl\multilang\behaviors\TranslationBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii2tech\ar\position\PositionBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * Article entity class
 *
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @property integer $id
 * @property string $key
 * @property integer $category_id
 * @property integer $author_id
 * @property boolean $show
 * @property integer $position
 * @property string $view
 * @property string $color
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $publish_at
 *
 * @property Category $category
 * @property ArticleViewCount $viewCount
 * @property ArticleViewCount[] $viewCounts
 * @property ArticleTranslation[] $translations
 * @property ArticleTranslation $translation
 * @method ArticleTranslation getTranslation($languageId = null)
 */
class Article extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => ArticleTranslation::className(),
                'relationColumn' => 'article_id'
            ],
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'position',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()')
            ]
        ];
    }

    public function rules()
    {
        return [
            ['category_id', 'number'],
            [['view', 'color'], 'string'],
            ['key', 'unique'],
            [['show'], 'boolean'],
            [['publish_at'], 'string']
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'publish_at' => Yii::t('articles', 'Publish date'),
            'show' => Yii::t('articles', 'Show')
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ArticleTranslation::className(), ['article_id' => 'id']);
    }

    public function getImagePath($id, $type, $category) {
        $dir = Yii::getAlias('@frontend/web/images/articles/');
        $article = Article::findOne($id);

        $imagePath = $dir . $type . '/' . $article->$type . '-' . $category . '.jpg';

        return $imagePath;
    }

    /**
     * @param $category
     * @param $size
     * @param bool $absolute
     * @return string Image.
     */
    public function getImage($category, $size, $absolute = false) {
        $dir = ($absolute) ? Yii::getAlias('@frontend/web/images/articles/') : '/images/articles/';
        $image = $dir . $category . '/' . $this->$category . '-' . $size . '.jpg';

        return $image;
    }

    /**
     * @return \yii\db\ActiveQuery|ArticleViewCount
     */
    public function getViewCount()
    {
        return $this->hasOne(ArticleViewCount::className(), ['article_id' => 'id'])
            ->onCondition(['{{article_view_count}}.viewer_id' => Yii::$app->user->id]);
    }

    /**
     * @return \yii\db\ActiveQuery|ArticleViewCount|ArticleViewCount[]
     */
    public function getViewCounts()
    {
        return $this->hasMany(ArticleViewCount::className(), ['article_id' => 'id']);
    }

    /**
     * Updates views counter.
     *
     * @return null|ArticleViewCount
     */
    public function updateViewCounter()
    {
        $userId = Yii::$app->user->id;
        $viewCount = $this->viewCount;

        if (!empty($viewCount)) {
            $viewCount->updateCounters(['count' => 1]);
        } else {
            $viewCount = new ArticleViewCount();
            $viewCount->article_id = $this->id;
            $viewCount->viewer_id = $userId;
            $viewCount->save();
            $viewCount->updateCounters(['count' => 1]);
        }

        return $viewCount;
    }

    /**
     * Checks whether a article is viewed by current user.
     *
     * @return bool
     */
    public function isNew()
    {
        return (empty($this->viewCount));
    }

    public function isToday()
    {
        return ($this->publish_at >= date('Y-m-d 00:00:00') && $this->publish_at <= date('Y-m-d 23:59:59'));
    }

    /**
     * Checks whether a article is published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return (date('Y-m-d H:i:s') >= $this->publish_at);
    }
}
