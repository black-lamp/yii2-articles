<?php

namespace bl\articles\frontend;

class Module extends \yii\base\Module
{
    const COUNT_VIEWS_PARAM = 'countViews';

    public $controllerNamespace = 'bl\articles\frontend\controllers';

    protected $defaultParams = [
        self::COUNT_VIEWS_PARAM => true
    ];

    public function init()
    {
        parent::init();

        $this->params = array_merge($this->defaultParams, $this->params);
    }
}
