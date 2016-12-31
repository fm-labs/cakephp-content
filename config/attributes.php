<?php
return [

    'Attributes' => [
        'Models' => [
            'Banana.Post' => [
                'html_meta_title' => [
                    'type' => 'string'
                ],
                'html_meta_robots' => [
                    'type' => 'select',
                    'options' => ['index' => 'index', 'nofollow' => 'nofollow']
                ],
            ]
        ]
    ]

];
