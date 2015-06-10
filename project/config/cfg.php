<?php

return [

    // API Logging
    'request_log' => true,
    'response_log' => true,
    'request_timestamp' => true,


    'verification_code_length' => 4,

    // Elastic
    'elastic_index' => 'nudge',
    'elastic_port' => '9200',
    'elastic_ip' => '134.213.153.40',
    'elastic_hosts' => ['134.213.153.40:9200'],

    // User default settings
    'user_default_settings' => [
        'notifications' => [
            'receive_nudge'     => true,
            'asked_referral'    => true,
            'matching_job'      => true,
            'message'           => true,
            'matching_contact'  => true,
        ]
    ],

    // Notification types
    'notifications' => [
        0 => 'receive_nudge',
        1 => 'asked_referral',
        2 => 'matching_job',
        3 => 'message',
        4 => 'matching_contact'
    ]

];
