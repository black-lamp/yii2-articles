Articles Extension for Yii 2
=====================================

INSTALLATION
------------

### Composer require section
```javascript
"black-lamp/yii2-articles": "0.*"
```

### Migrate

    php yii migrate --migrationPath=@yii/rbac/migrations
	php yii migrate --migrationPath=@vendor/black-lamp/yii2-multi-lang/migration
	php yii migrate --migrationPath=@vendor/black-lamp/yii2-articles/common/migrations
	php yii migrate --migrationPath=@vendor/black-lamp/yii2-seo/migrations

### Add articles module to your backend config
```php
    'modules' => [
    	...
        'articles' => [
            'class' => 'bl\articles\backend\Module'
        ],
        ...
    ]
```

### Add articles module to your frontend config
```php
    'modules' => [
    	...
        'articles' => [
            'class' => 'bl\articles\frontend\Module'
        ],
        ...
    ]
```

### Configure seo-url rule
```php
	'urlManager' => [
		...
		'rules' => [
			...
			[
			    'class' => 'bl\articles\UrlRule'
			]
		]
	]
```

### Configure Imagable module
```php
    'components' => [
        ...
        'articles_imagable' => [
            'class' => bl\imagable\Imagable::className(),
            'imageClass' => CreateImageImagine::className(),
            'nameClass' => bl\imagable\name\CRC32Name::className(),
            'imagesPath' => '@frontend/web/images',
            'categories' => [
                'origin' => false,
                'category' => [
                    'thumbnail' => [
                        'origin' => false,
                        'size' => [
                            'big' => [
                                'width' => 1500,
                                'height' => 500
                            ],
                            'thumb' => [
                                'width' => 500,
                                'height' => 500,
                            ],
                            'small' => [
                                'width' => 150,
                                'height' => 150
                            ]
                        ]
                    ],
                    'menu_item' => [
                        'origin' => false,
                        'size' => [
                            'big' => [
                                'width' => 1500,
                                'height' => 500
                            ],
                            'thumb' => [
                                'width' => 500,
                                'height' => 500,
                            ],
                            'small' => [
                                'width' => 150,
                                'height' => 150
                            ]
                        ]
                    ],
                    'social' => [
                        'origin' => true,
                        'size' => [
                            'big' => [
                                'width' => 1500,
                                'height' => 500
                            ],
                            'thumb' => [
                                'width' => 500,
                                'height' => 500,
                            ],
                            'small' => [
                                'width' => 150,
                                'height' => 150
                            ]
                        ]
                    ],
                ]
            ]
        ],
    ]
```

### Use
	yourbackend.url/articles/article
	
	**YOU MUST CONFIGURE IMAGABLE COMPONENT**

**Roles and its permissions:**

_articleManager_
- viewArticleList
- editArticles
- deleteArticles

_articleCategoryManager_
- viewCategoryList
- editCategories
- deleteCategories

_articleAdministrator_
extends category and article manager's permissions. 