<?php

namespace bl\articles\backend;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\articles\backend\controllers';
    public $defaultRoute = 'article';

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        if (!isset(\Yii::$app->i18n->translations['articles'])) {
            \Yii::$app->i18n->translations['articles'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath'       => '@vendor/black-lamp/yii2-articles/backend/messages',
            ];
        }
    }
}
