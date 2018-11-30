<?php

use Phalcon\Config;

return new Config(
    [
        "database" => [
            "adapter" => "Mysql",
            "host" => DB_HOST,
            "username" => DB_USER,
            "password" => DB_PASSWORD,
            "dbname" => DB_NAME,
            'charset' => 'utf8',
            'options' => [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]
        ],
        "application" => [
            'baseUri' => '/',
            'publicUrl' => APP_PUBLIC_URL,
            'cryptSalt' => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
            "baseUri" => "/",
        ],
    ]
);
