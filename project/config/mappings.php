<?php

return [

    'skill' => [
        '_source' => [
            'enabled' => true
        ],
        'properties' => [
            'name' => [
                'type' => 'completion',
            ]
        ]
    ],

    'job' => [
        '_source' => [
            'enabled' => true
        ],
        '_all' => [
            'enabled' => true
        ],
        'properties' => [
            'title' => [
                'type' => 'string',
                'index' => 'analyzed',
                'include_in_all' => true
            ],
            'description' => [
                'type' => 'string',
                'index' => 'analyzed',
                'include_in_all' => true
            ],
            'skills' => [
                'type' => 'string',
                'index' => 'analyzed',
                'include_in_all' => false
            ],
            'bonus' => [
                'type' => 'double',
                'index' => 'not_analyzed',
                'include_in_all' => false
            ],

            'active' => [
                'type' => 'integer',
                'index' => 'not_analyzed',
                'include_in_all' => false
            ],

            'user_id' => [
                'type' => 'integer',
                'index' => 'not_analyzed',
                'include_in_all' => false
            ]
        ]
    ]
];


