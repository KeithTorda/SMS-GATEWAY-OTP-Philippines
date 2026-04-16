<?php

use App\Core\Env;

return [
    'db' => [
        'host' => Env::get('DB_HOST', 'localhost'),
        'name' => Env::get('DB_NAME', 'database_name'),
        'user' => Env::get('DB_USER', 'database_user'),
        'pass' => Env::get('DB_PASS', ''), 
    ],
    'app' => [
        'url' => Env::get('APP_URL', 'http://localhost/native-sms/public'),
        'name' => Env::get('APP_NAME', 'SMS Gateway Dashboard'),
    ]
];
