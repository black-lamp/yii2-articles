<?php
namespace bl\articles\common\entities;

use bl\multilang\behaviors\TranslationBehavior;
use yii\db\ActiveRecord;

/**
 * Category model
 *
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @property integer $id
 * @property string $key
 * @property integer $parent_id
 * @property boolean $show
 * @property boolean $show_articles
 * @property string $color
 * @property string $view
 * @property string $article_view
 *
 * @property Article[] $articles
 * @property Article[] $allArticles
 * @property Category[] $children
 *
 * @property CategoryTranslation[] $translations
 * @property CategoryTranslation $translation
 * 
 * @method TranslationBehavior getTranslation($languageId = null)
 */
class Category extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => TranslationBehavior::className(),
                'translationClass' => CategoryTranslation::className(),
                'relationColumn' => 'category_id'
            ]
        ];
    }

    public function rules()
    {
        return [
            ['parent_id', 'number'],
            [['show', 'show_articles'], 'boolean'],
            [['view', 'article_view', 'color'], 'string'],
            ['key', 'unique']
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    public function getAllArticles($category = null) {

        if($category == null) {
            $category = $this;
        }

        $articles = $category->articles;

        if(!empty($category->children)) {
            foreach($category->children as $child) {
                $articles = array_merge($articles, $child->getAllArticles());
            }
        }

        usort($articles, function($a, $b) {
            if(strtotime($a->created_at) < strtotime($b->created_at))
                return 1;
            else
                return -1;
            return 0;
        });

        return $articles;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(CategoryTranslation::className(), ['category_id' => 'id']);
    }
}