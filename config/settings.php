<?php
return [
    'Settings' => [
        'Content' => [
            'groups' => [
                'Content' => [
                    'label' => __d('content', 'Content'),
                ],
            ],

            'schema' => [
                'Content.Router.enablePrettyUrls' => [
                    'type' => 'boolean',
                    'help' => 'Enables SEO-friendly URIs',
                ],
                'Content.Router.forceCanonical' => [
                    'type' => 'boolean',
                    'help' => 'Force redirect to canonical URI',
                ],
            ],
        ],
    ],
];
