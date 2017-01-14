<?php
return [
    'Content.Backend.Menu' => [
        'title' => 'Content',
        'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index', 'type' => 'page'],
        'data-icon' => 'book',
        'children' => [

            'posts' => [
                'title' => 'Posts',
                'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index', 'type' => 'post'],
                'data-icon' => 'file-o',
            ],

            'pages' => [
                'title' => 'Pages',
                'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index', 'type' => 'page'],
                'data-icon' => 'desktop',
            ],

            'menus' => [
                'title' => 'Menus',
                'url' => ['plugin' => 'Content', 'controller' => 'Menus', 'action' => 'index'],
                'data-icon' => 'sitemap'
            ],

            'galleries' => [
                'title' => 'Galleries',
                'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                'data-icon' => 'image'
            ],


            'page_layouts' => [
                'title' => 'Layouts',
                'url' => ['plugin' => 'Content', 'controller' => 'PageLayouts', 'action' => 'index'],
                'data-icon' => 'columns'
            ],
            'module_builder' => [
                'title' => 'Module Builder',
                'url' => ['plugin' => 'Content', 'controller' => 'ModuleBuilder', 'action' => 'index'],
                'data-icon' => 'magic'
            ],
            'modules' => [
                'title' => 'Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'Modules', 'action' => 'index'],
                'data-icon' => 'puzzle-piece'
            ],
            'content_modules' => [
                'title' => 'Content Modules',
                'url' => ['plugin' => 'Content', 'controller' => 'ContentModules', 'action' => 'index'],
                'data-icon' => 'object-group'
            ],

            'pages_legacy' => [
                'title' => 'Pages (Legacy)',
                'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                'data-icon' => 'sitemap'
            ],
        ],
    ]
];