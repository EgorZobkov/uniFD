<?php

$config_app = require BASE_PATH.'/config/app.php';

return [
    'path' => BASE_PATH . '/resources',
    'answer' => [
        'path' => BASE_PATH . '/resources/answers',
    ],
    'mail' => [
        'path' => BASE_PATH . '/resources/mail',
    ],
    'view' => [
        'dashboard' => [
            'path' => BASE_PATH . '/resources/view/'.$config_app["dashboard_alias"],
        ],
        'web' => [
            'path' => BASE_PATH . '/resources/view/web',
        ],
    ],
    'components' => [
        'dashboard' => BASE_PATH . '/resources/view/'.$config_app["dashboard_alias"].'/components',
        'web' => BASE_PATH . '/resources/view/web/components',
    ],
    'assets' => [
        'dashboard' => [
            'base' =>  BASE_PATH . '/resources/view/'.$config_app["dashboard_alias"].'/assets',
            'css' =>  BASE_PATH . '/resources/view/'.$config_app["dashboard_alias"].'/assets/css',
            'js' => BASE_PATH . '/resources/view/'.$config_app["dashboard_alias"].'/assets/js',
            'images' => BASE_PATH . '/resources/view/'.$config_app["dashboard_alias"].'/assets/images',
        ],
        'web' => [
            'base' =>  BASE_PATH . '/resources/view/web/assets',
            'css' => BASE_PATH . '/resources/view/web/assets/css',
            'js' => BASE_PATH . '/resources/view/web/assets/js',
            'images' => BASE_PATH . '/resources/view/web/assets/images',
        ],
    ]
];
