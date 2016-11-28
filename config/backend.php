<?php
return [
    'Backend.Plugin.Content.Menu' => [

        'app' => [

            [
                'title' => 'Content',
                'url' => ['plugin' => 'Content', 'controller' => 'ContentManager', 'action' => 'index'],
                'data-icon' => 'book',
                'children' => [

                    'posts' => [
                        'title' => 'Posts',
                        'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                        'data-icon' => 'desktop',
                    ],

                    'menus' => [
                        'title' => 'Menus',
                        'url' => ['plugin' => 'Content', 'controller' => 'Menus', 'action' => 'manage'],
                        'data-icon' => 'sitemap'
                    ],

                    'galleries' => [
                        'title' => 'Galleries',
                        'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                        'data-icon' => 'image'
                    ],

                    'pages' => [
                        'title' => 'Pages (Legacy)',
                        'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                        'data-icon' => 'sitemap'
                    ],

                    'page_layouts' => [
                        'title' => 'Layouts',
                        'url' => ['plugin' => 'Content', 'controller' => 'PageLayouts', 'action' => 'index'],
                        'data-icon' => 'file'
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
                ],
            ],


        ],
    ]
];