<?php

namespace bl\articles\backend;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bl\articles\backend\controllers';
    public $defaultRoute = 'article';

    public $tabs = [];

    public function init()
    {
        parent::init();
        $this->registerTabs();
        $this->registerTranslations();
    }

    public function registerTabs() {
        foreach ($this->tabs as $tabTitle => $tabData) {
            $this->controllerMap[$tabTitle] = $tabData['controller'];
        }
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
