<?php
namespace bl\articles\common\entities;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "article_view".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $viewer_id
 * @property integer $count
 *
 * @property Article $article
 */
class ArticleViewCount extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_view_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id', 'viewer_id', 'count'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('articles', 'ID'),
            'article_id' => Yii::t('articles', 'Article ID'),
            'viewer_id' => Yii::t('articles', 'Viewer ID'),
            'count' => Yii::t('articles', 'Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}