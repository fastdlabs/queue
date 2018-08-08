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
    ],

    'work_queues' => 'default',

    'workers' => 4,

    'sleep_interval' => 5,

    'max_jobs' => 10000,

    'max_error_times' => 10,

    'error_interval' => 1,
];