<?php

use Phalcon\Config;

return new Config(
    [
        "database" => [
            "adapter"     => "Mysql",
            "host"        => "localhost",
            "username"    => "root",
            "password"    => "Diego2356",
            "dbname"      => "vendinha",
        ],
        "application" => [
            "controllersDir" => __DIR__ . "/../../site/controllers/",
            "modelsDir"      => __DIR__ . "/../../site/models/",
            "viewsDir"       => __DIR__ . "/../../site/views/",
            "pluginsDir"     => __DIR__ . "/../../site/plugins/",
            "libraryDir"     => __DIR__ . "/../../site/library/",
            "cacheDir"       => __DIR__ . "/../../site/cache/",
            "baseUri"        => "/mvc/simple-volt/",
        ],
    ]
);
