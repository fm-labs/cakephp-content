<?php
return [
    'Content' => [
        'Router' => [
            'scope' => 'content',
            'enablePrettyUrls' => false,
            'forceCanonical' => false,
        ],
        'HtmlEditor' => [
            'default' => [
                'convert_urls' => false,
                'image_list_url' => ['plugin' => 'Content', 'controller' => 'HtmlEditor', 'action' => 'imageList'],
                'link_list_url' => ['plugin' => 'Content', 'controller' => 'HtmlEditor', 'action' => 'linkList']
            ],
        ]
    ]
];