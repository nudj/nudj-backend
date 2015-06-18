<?php

return [

    // API Logging
    'request_log' => true,
    'response_log' => true,
    'request_timestamp' => true,

    // Directories
    'dir_upload' => 'upload',


    // Chat Server
    'chat_server_ip' => '162.13.187.75:4560',
    'chat_server_host' => 'chat.nudj.co',

    // Exceptions
    'email_system' => 'no-reply@nudj.co',
    'email_notifications' => 'ivan@e-man.co.uk',

    // Rackspace
    'rackspace' => [
        'apiKey' => '4bf56f4a6bb94562b9f1bcd2d0a2e919',
        'username' => 'nudge2015',
        'location' => 'LON',
    ],

    // Elastic
    'elastic_index' => 'nudge',
    'elastic_port' => '9200',
    'elastic_ip' => '134.213.153.40',
    'elastic_hosts' => ['134.213.153.40:9200'],

    // Random settings
    'verification_code_length' => 4,

    // User default settings
    'user_default_settings' => [
        'notifications' => [
            'receive_nudge' => true,
            'asked_referral' => true,
            'matching_job' => true,
            'message' => true,
            'matching_contact' => true,
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
