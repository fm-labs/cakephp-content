<?php
return [
    'Content.Backend.Menu' => [
        'title' => 'Content',
        'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
        'data-icon' => 'book',
        'children' => [

            'categories' => [
                'title' => 'Categories',
                'url' => ['plugin' => 'Content', 'controller' => 'Categories', 'action' => 'index'],
                'data-icon' => 'folder-o',
            ],

            'posts' => [
                'title' => 'Posts',
                'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                'data-icon' => 'file-o',
            ],

            'pages' => [
                'title' => 'Pages',
                'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                'data-icon' => 'desktop',
            ],

            'nodes' => [
                'title' => 'Nodes',
                'url' => ['plugin' => 'Content', 'controller' => 'Nodes', 'action' => 'index'],
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

            /*
            'pages_legacy' => [
                'title' => 'Pages (Legacy)',
                'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                'data-icon' => 'sitemap'
            ],
            */
        ],
    ],

];