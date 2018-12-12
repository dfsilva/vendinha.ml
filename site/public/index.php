<?php

error_reporting(E_ALL);

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application as BaseApplication;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View\Engine\Php as PhpViewEngine;
use Phalcon\Loader;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;


class Application extends BaseApplication
{

    public function initVariables()
    {
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
    }

    public function main()
    {
        $this->initVariables();

        if (APP_DEBUG) {
            $debug = new Phalcon\Debug();
            $debug->listen();
        }

        $config = include __DIR__ . '/../app/config/conf.php';

        $loader = new Loader();

        $loader->registerDirs([
            __DIR__ . '/../app/controllers',
            __DIR__ . '/../app/plugins'
        ])->register();


        $di = new FactoryDefault();
        $di->set('config', $config, true);


        $di['router'] = function () {

            $router = new \Phalcon\Mvc\Router();

            $router->add('/', [
                'controller' => 'index',
                'action' => 'index'
            ]);

            $router->add('/test', [
                'controller' => 'index',
                'action' => 'test'
            ]);

            $router->add('/vender-produtos', [
                'controller' => 'venda',
                'action' => 'produtos'
            ]);

            return $router;
        };


        $di->set('url', function () {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/');
            $url->setBasePath('/');

            return $url;
        }, true);

        $di->set(
            "view",
            function () use ($config) {
                $view = new View();

                $view->setViewsDir(
                    __DIR__ . '/../app/views'
                );

                $view->setLayoutsDir(__DIR__ . '/../app/layouts/');
                $view->setPartialsDir(__DIR__ . '/../app/partials/');
                $view->setLayout('site');

                $view->registerEngines(
                    [
                        ".volt" => function ($view, $di) use ($config) {
                            $volt = new VoltEngine($view, $di);

                            $volt->setOptions(
                                [
                                    "compiledPath"      => __DIR__.'/../app/cache/',
                                    "compiledSeparator" => "_",
                                ]
                            );

                            return $volt;
                        },
                        ".phtml" => PhpViewEngine::class
                    ]
                );
                return $view;
            },
            true
        );

        $di->set('dispatcher', function () {
            $dispatcher = new MvcDispatcher();
            $eventsManager = new EventsManager;
            $eventsManager->attach('dispatch:beforeException', new \NotFoundPlugin);
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        }, true);


        $di->set('session', function () {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });


        $di->set('log', function () {
            $logger = new FileAdapter(__DIR__ . "/../app/logs/app.log", ['mode' => 'w']);
            if (APP_DEBUG) {
                $logger->setLogLevel(Logger::DEBUG);
            } else {
                $logger->setLogLevel(Logger::ERROR);
            }
            return $logger;
        });



        $di->set('db', function () {

            $connection = new Connection([
                "host" => DB_HOST,
                "username" => DB_USER,
                "password" => DB_PASSWORD,
                "dbname" => DB_NAME,
                "charset" => 'utf8'
            ]);

            if (APP_DEBUG) {
                $eventsManager = new Phalcon\Events\Manager();
                $logger = new FileAdapter(__DIR__ . "/logs/db.log");
                $eventsManager->attach('db', function ($event, $connection) use ($logger) {
                    if ($event->getType() == 'beforeQuery') {
                        $logger->log($connection->getSQLStatement(), \Phalcon\Logger::DEBUG);
                    }
                });
                $connection->setEventsManager($eventsManager);
            }

            return $connection;
        });


//        $assetsManager = new Phalcon\Assets\Manager();
//        $assetsManager->collection('jsSiteBase')
//            ->setTargetPath('jsSiteBase.js')
//            ->setTargetUri('assets/jsSiteBase.js')
//            ->addJs(APP_ENV == 'prod' ? 'https://cdn.jsdelivr.net/npm/vue' : 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', false, true)
//            ->addJs('https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js', false, true)
//            ->join(true)
//            ->addFilter(new Phalcon\Assets\Filters\Jsmin());
//
//        $di->set('assets', $assetsManager);


//
//        $eventsManager = new EventsManager;
//        $eventsManager->attach('dispatch:beforeException', new \NotFoundPlugin);
//        $dispatcher = new Dispatcher;
//        $dispatcher->setEventsManager($eventsManager);
//
//        $di->setShared('dispatcher', $dispatcher);

        $this->setDI($di);
        echo $this->handle()->getContent();
    }
}

$application = new Application();
$application->main();
