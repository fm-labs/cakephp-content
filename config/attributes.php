<?php
return [
    'Attributes' => [
        'Models' => [
            'Content.Post' => [
                'html_meta_title' => [
                    'type' => 'string'
                ],
                'html_meta_desc' => [
                    'type' => 'text'
                ],
                'html_meta_robots' => [
                    'type' => 'select',
                    'options' => ['index' => 'index', 'nofollow' => 'nofollow'],
                    'empty' => false,
                ],
                'faq_category_id' => [
                    'type' => 'select',
                    'model' => 'Content.Category'
                ]
            ]
        ]
    ]
];
