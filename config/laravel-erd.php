<?php

use Kevincobain2000\LaravelERD\Diagram\RoutingType;

return [
    'models_path' => sprintf('%s/Domains/**/Models', base_path('app/')),
    'docs_path' => base_path('docs/.vuepress/public/erd'),

    'display' => [
        'show_data_type' => false,
        'routing' => RoutingType::ORTHOGONAL,
    ],
];
