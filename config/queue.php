<?php

return [
    'connection' => 'redis',

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'schema' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
            'password' => null,
            'database' => 0,
            'prefix' => 'queue',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'pass' => 'root',
            'database' => 'queue',
            'table' => 'queue',
        ],
    ]
];