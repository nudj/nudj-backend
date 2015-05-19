<?php

return [

    // API Logging
    'request_log' => true,
    'request_timestamp' => true,


    'verification_code_length' => 5,


    'elastic_index' => 'nudge',
    'elastic_port' => '9200',
    'elastic_ip' => '192.168.3.45',
    'elastic_hosts' => ['192.168.3.45:9200'],


    'user_default_settings' => [
        'notifications' => [
            'receive_nudge'     => true,
            'asked_referral'    => true,
            'matching_job'      => true,
            'message'           => true,
            'matching_contact'  => true,
        ]
    ],


    'notifications' => [
        0 => 'receive_nudge',
        1 => 'asked_referral',
        2 => 'matching_job',
        3 => 'message',
        4 => 'matching_contact'
    ]

];
