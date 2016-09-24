<?php
return [
    'Content' => [
        'Router' => [
            'disableFrontendRoutes' => false,
            'disableAdminRoutes' => false,
            'enablePrettyUrls' => true,
            'forceCanonical' => false,
        ],
        'HtmlEditor' => [
            'default' => [
                'convert_urls' => false,
                'image_list_url' => ['plugin' => 'Content', 'controller' => 'HtmlEditor', 'action' => 'imageList'],
                'link_list_url' => ['plugin' => 'Content', 'controller' => 'HtmlEditor', 'action' => 'linkList']
            ],
        ],
        'Frontend' => [
            'theme' => null
        ],
        'Modules' => [
        ]
    ]
];