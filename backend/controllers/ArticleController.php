<?php

namespace bl\articles\backend\controllers;

use bl\articles\backend\components\form\ArticleImageForm;
use bl\articles\common\entities\Article;
use bl\articles\common\entities\ArticleTranslation;
use bl\articles\common\entities\Category;
use bl\multilang\entities\Language;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class ArticleController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'roles' => ['viewArticleList'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'save', 'add-basic', 'add-images',
                            'delete-image',
                            'up', 'down', 'switch-show',
                            'get-seo-url'
                        ],
                        'roles' => ['editArticles'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['remove'],
                        'roles' => ['deleteArticles'],
                        'allow' => true,
                    ],
                ],
            ]
        ];
    }


    public function actionIndex()
    {
        return $this->render('index', [
            'articles' => Article::find()
                ->with(['category', 'category.translations', 'translations'])
                ->orderBy(['category_id' => SORT_ASC, 'position' => SORT_ASC])
                ->all(),
            'languages' => Language::findAll(['active' => true])
        ]);
    }

    public function actionSave($languageId = null, $articleId = null)
    {
        if (!empty($articleId)) {
            $article = Article::findOne($articleId);
            $article_translation = ArticleTranslation::find()->where([
                'article_id' => $articleId,
                'language_id' => $languageId
            ])->one();
            if (empty($article_translation))
                $article_translation = new ArticleTranslation();
        } else {
            $article = new Article();
            $article_translation = new ArticleTranslation();
        }

        if (Yii::$app->request->isPost) {
            $article->load(Yii::$app->request->post());
            $article_translation->load(Yii::$app->request->post());

            if ($article->validate() && $article_translation->validate()) {
                $article->save();

                if (empty($article_translation->seoUrl)) {
                    $article_translation->seoUrl = Inflector::slug($article_translation->name);
                }
                $article_translation->article_id = $article->id;
                $article_translation->language_id = $languageId;
                $article_translation->save();
                Yii::$app->getSession()->setFlash('success', 'Data were successfully modified.');

                return $this->redirect(['save', 'articleId' => $article->id, 'languageId' => $languageId]);
            }
            else {
                Yii::$app->getSession()->setFlash('danger', 'Failed to change the record.');
            }
        }

        return $this->render('save',
            [
                'article' => $article,
                'article_translation' => $article_translation,
                'categories' => Category::find()->with('translations')->all(),
                'selectedLanguage' => Language::findOne($languageId),
                'languages' => Language::findAll(['active' => true]),
                'viewName' => 'add-basic',
                'languageId' => $languageId,
                'params' => [
                    'article' => $article,
                    'article_translation' => $article_translation,
                    'categories' => Category::find()->with('translations')->all(),
                    'selectedLanguage' => Language::findOne($languageId),
                    'languages' => Language::findAll(['active' => true]),
                ]
            ]
        );
    }

    public function actionAddBasic($articleId, $languageId)
    {
        if (!empty($articleId)) {
            $article = Article::findOne($articleId);
            $article_translation = ArticleTranslation::find()->where([
                'article_id' => $articleId,
                'language_id' => $languageId
            ])->one();
            if (empty($article_translation))
                $article_translation = new ArticleTranslation();
        } else {
            $article = new Article();
            $article_translation = new ArticleTranslation();
        }

        if (Yii::$app->request->isPost) {
            $article->load(Yii::$app->request->post());
            $article_translation->load(Yii::$app->request->post());

            if ($article->validate() && $article_translation->validate()) {
                $article->save();
                $article_translation->article_id = $article->id;
                $article_translation->language_id = $languageId;
                $article_translation->save();
                Yii::$app->getSession()->setFlash('success', 'Data were successfully modified.');
            } else
                Yii::$app->getSession()->setFlash('danger', 'Failed to change the record.');
        }

        if (\Yii::$app->request->isPjax) {
            return $this->renderPartial('add-basic',
                [
                    'article' => $article,
                    'article_translation' => $article_translation,
                    'categories' => Category::find()->with('translations')->all(),
                    'selectedLanguage' => Language::findOne($languageId),
                    'languages' => Language::findAll(['active' => true])
                ]);
        }
        else {
            return $this->render('save',
                [
                    'article' => $article,
                    'languageId' => $languageId,
                    'viewName' => 'add-basic',
                    'params' => [
                        'article' => $article,
                        'article_translation' => $article_translation,
                        'categories' => Category::find()->with('translations')->all(),
                        'selectedLanguage' => Language::findOne($languageId),
                        'languages' => Language::findAll(['active' => true]),
                    ]
                ]
            );
        }
    }

    public function actionAddImages($articleId, $languageId)
    {

        if (!empty($articleId)) {
            $article = Article::findOne($articleId);

            $image_form = new ArticleImageForm();

            if (Yii::$app->request->isPost) {
                // TODO: rename article categories
                $image_form->social = UploadedFile::getInstance($image_form, 'social');
                $image_form->thumbnail = UploadedFile::getInstance($image_form, 'thumbnail');
                $image_form->menu_item = UploadedFile::getInstance($image_form, 'menu_item');

                if (!empty($image_form->social) || !empty($image_form->thumbnail) || !empty($image_form->menu_item)) {


                    $image_name = $image_form->upload();
                    if (!empty($image_form->social)) {
                        $article->social = $image_name['social'];
                    }
                    if (!empty($image_form->thumbnail)) {
                        $article->thumbnail = $image_name['thumbnail'];
                    }
                    if (!empty($image_form->menu_item)) {
                        $article->menu_item = $image_name['menu_item'];
                    }
                }

                if ($article->validate()) {
                    $article->save();

//                    return $this->redirect(Url::toRoute('/articles/article'));
                }

            }

            if (Yii::$app->request->isPjax)
            {
                return $this->renderPartial('add-images', [
                    'article' => $article,
                    'image_form' => $image_form,
                    'languageId' => $languageId
                ]);
            }
            else return $this->render('save', [
                'article' => $article,
                'languageId' => $languageId,
                'viewName' => 'add-images',
                'params' => [
                    'article' => $article,
                    'image_form' => $image_form,
                    'languageId' => $languageId
                ]
            ]);
        }
        return false;

    }

    public function actionDeleteImage($id, $type)
    {
        if (!empty($id) && !empty($type)) {

            $article = Article::findOne($id);
            if (file_exists($article->getImagePath($id, $type, 'big'))) {
                unlink($article->getImagePath($id, $type, 'big'));
            }
            if (file_exists($article->getImagePath($id, $type, 'small'))) {
                unlink($article->getImagePath($id, $type, 'small'));
            }
            if (file_exists($article->getImagePath($id, $type, 'thumb'))) {
                unlink($article->getImagePath($id, $type, 'thumb'));
            }
            if (file_exists($article->getImagePath($id, $type, 'origin'))) {
                unlink($article->getImagePath($id, $type, 'origin'));
            }

            $article->$type = null;
            $article->save();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemove($id)
    {
        Article::deleteAll(['id' => $id]);
        return $this->redirect(Url::to(['/articles/article']));
    }

    public function actionUp($id)
    {
        if ($article = Article::findOne($id)) {
            $article->movePrev();
        }

        return $this->redirect(Url::to(['/articles/article']));
    }

    public function actionDown($id)
    {
        if ($article = Article::findOne($id)) {
            $article->moveNext();
        }

        return $this->redirect(Url::to(['/articles/article']));
    }

    public function actionSwitchShow($id)
    {
        /* @var Article $article */
        if ($article = Article::findOne($id)) {
            $article->show = !$article->show;
            $article->save();
        }

        return $this->redirect(Url::to(['/articles/article']));
    }

    public function actionGetSeoUrl($name)
    {
        return Inflector::slug($name);
    }
}
