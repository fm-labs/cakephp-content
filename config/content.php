<?php
return [
    'HtmlEditor' => [
        'content' => [
            'convert_urls' => false,
            '@image_list' => ['plugin' => 'Content', 'controller' => 'HtmlEditor', 'action' => 'imageList'],
            '@link_list' => ['plugin' => 'Content', 'controller' => 'HtmlEditor', 'action' => 'linkList']
        ],
    ],
    'Content' => [
        'Router' => [
            'scope' => 'content',
            'enablePrettyUrls' => false,
            'forceCanonical' => false,
        ],
    ]
];