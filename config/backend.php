<?php
return [
    'Backend.Plugin.Content' => [
        'Menu' => [
            'title' => 'Content',
            'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
            'data-icon' => 'desktop',

            '_children' => [
                'pages' => [
                    'title' => 'Pages',
                    'url' => ['plugin' => 'Content', 'controller' => 'Pages', 'action' => 'index'],
                    'data-icon' => 'sitemap'
                ],
                'posts' => [
                    'title' => 'Posts',
                    'url' => ['plugin' => 'Content', 'controller' => 'Posts', 'action' => 'index'],
                    'data-icon' => 'edit'
                ],
                'galleries' => [
                    'title' => 'Galleries',
                    'url' => ['plugin' => 'Content', 'controller' => 'Galleries', 'action' => 'index'],
                    'data-icon' => 'image'
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
                'themes_manager' => [
                    'title' => 'Theme',
                    'url' => ['plugin' => 'Content', 'controller' => 'ThemesManager', 'action' => 'index'],
                    'data-icon' => 'paint-brush'
                ],
                'menus' => [
                    'title' => 'Menus',
                    'url' => ['plugin' => 'Content', 'controller' => 'Menus', 'action' => 'index'],
                    'data-icon' => ''
                ],
                'menu_items' => [
                    'title' => 'Menu Items',
                    'url' => ['plugin' => 'Content', 'controller' => 'MenuItems', 'action' => 'index'],
                    'data-icon' => ''
                ],
            ]
        ]
    ]
];