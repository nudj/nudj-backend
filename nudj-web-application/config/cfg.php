<?php

return [

    // API Logging
    'request_log'       => false,
    'request_timestamp' => true,

    // Directories
    'dir_upload' => 'upload',

    // Chat Server
    'chat_server_ip'         => '162.13.187.75:4560',
    'chat_server_host'       => 'chat.nudj.co',
    'chat_server_at'         => '@chat.nudj.co',
    'chat_server_tcp'        => 'tcp://chat.nudj.co:5222',
    'chat_conference_domain' => '@conference.chat.nudj.co',

    // Exceptions
    'email_system'        => 'no-reply@nudj.co',
    'email_notifications' => 'pascal@nudj.co',
    'email_feedback'      => 'pascal@nudj.co',

    // Rackspace
    'rackspace' => [
        'apiKey'   => '4bf56f4a6bb94562b9f1bcd2d0a2e919',
        'username' => 'nudge2015',
        'location' => 'LON',
    ],

    // Facebook
    'facebook_app_id'     => '436716026489484',
    'facebook_app_secret' => 'fb7575dae2525ca8301c74c7b87ed26d',

    // ---------------------------------------------------------------------
    // TODO: The below is commented out waiting to be deleted
    // LinkedIn
    // 'linkedin_app_id'     => '77l67v0flc6leq',
    // 'linkedin_app_secret' => 'PLOAmXuwsl1sSooc',
    // ---------------------------------------------------------------------    

    // SMS Messaging
    'twilio_sid'    => 'AC5417072b3b78fe9375f2f8f795a26e74',
    'twilio_token'  => '3170bb423fd0155a274ddf2a9f1dd9b4',
    'twilio_number' => '+44 20 3322 3966',

    // Elastic
    'elastic_index' => 'nudge',
    'elastic_port'  => '9200',
    'elastic_ip'    => '134.213.153.40',
    'elastic_hosts' => ['134.213.153.40:9200'],

    // Random settings
    'verification_code_length' => 4,
    'default_hash_length'      => 4,

    // System User
    'sys_id'    => 1,
    'sys_name'  => 'sys',
    'sys_token' => 'sys-7xngvxq1uGF8BWpEwjmmg1NfAqxdYHL4xqgXBCtxwYcxJH3un1Foh0nz'

];
