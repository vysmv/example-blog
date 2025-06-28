<?php

return [
    'app_namespace'             => app()->getNamespace(),
    'home_route'                => '',
    'standart_entities_enabled' => env('EASYSTART_ENTITIES_ENABLED', false),
    'admin_options' => [
        'app_name'  => env('EASYSTART_APP_NAME', env('EASYSTART_ENTITIES_ENABLED', 'Your app name')),
        'copyright' => env('EASYSTART_COPYRIGHT', 'Your copyright text')
    ],
    'docker' => [
        'db_name'           => 'easy_start',
        'minio_backet_name' => 'easy-start'
    ],
];
