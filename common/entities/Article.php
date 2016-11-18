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
 * @property ArticleTranslation[] $translations
 * @property ArticleTranslation $translation
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
}
