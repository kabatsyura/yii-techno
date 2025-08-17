<?php

declare(strict_types=1);

use yii\db\Connection;
use yii\gii\Module as GiiModule;
use yii\debug\Module as DebugModule;

$config = [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'pgsql:host=db;port=5432;dbname=yii2db',
            'username' => 'yii2user',
            'password' => 'yii2password',
            'charset' => 'utf8',
        ],
    ],
];

return $config;
