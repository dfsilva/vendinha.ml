<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View\Simple as View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger;



define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_NAME', getenv('DB_NAME'));
define('APP_DEBUG', getenv('APP_DEBUG'));
define('APP_ENV', getenv('APP_ENV'));
define('APP_PUBLIC_URL', getenv('APP_PUBLIC_URL'));

define('FIB_API_KEY', getenv('FIB_API_KEY'));
define('FIB_AUTH_DOMAIN', getenv('FIB_AUTH_DOMAIN'));
define('FIB_DB_URL', getenv('FIB_DB_URL'));
define('FIB_PJ_ID', getenv('FIB_PJ_ID'));
define('FIB_ST_BUCKET', getenv('FIB_ST_BUCKET'));
define('FIB_MSG_SENDER_ID', getenv('FIB_MSG_SENDER_ID'));

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

$di->set('log', function () {
    $logger = new FileAdapter(__DIR__ . "/../logs/api.log", ['mode' => 'w']);
    if (APP_DEBUG) {
        $logger->setLogLevel(Logger::DEBUG);
    } else {
        $logger->setLogLevel(Logger::ERROR);
    }
    return $logger;
});
