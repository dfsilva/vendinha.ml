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
        define('MAPS_API_KEY', getenv('MAPS_API_KEY'));

        define('API_URL', getenv('API_URL'));
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

//                $eventsManager = new EventsManager();
//                $eventsManager->attach(
//                    'view:afterRender',
//                    new \TidyPlugin()
//                );

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
                                    "compiledPath" => __DIR__ . '/../app/cache/',
                                    "compiledSeparator" => "_",
                                    'compileAlways'     => APP_ENV != 'prod' ? true : false
                                ]
                            );

                            return $volt;
                        },
                        ".phtml" => PhpViewEngine::class
                    ]
                );

//                $view->setEventsManager($eventsManager);

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

        $assetsManager = new Phalcon\Assets\Manager();
        $assetsManager->collection('jsBase')
            ->setTargetPath('assets/dist/jsBase.js')
            ->setTargetUri('assets/dist/jsBase.js')
            ->addJs('assets/vue-2.5.21/dist/vue.js')
            ->addJs('assets/vuetify-v1.4.0-beta.0/vuetify-v1.4.0-beta.0.js')
            ->addJs('assets/js/utils.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());

        $assetsManager->collection('dialogAddVideoJs')
            ->setTargetPath('assets/dist/dialogAddVideoJs.js')
            ->setTargetUri('assets/dist/dialogAddVideoJs.js')
            ->addJs('assets/js/vue-comp/DialogAddVideo.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());

        $assetsManager->collection('youtubeVidJs')
            ->setTargetPath('assets/dist/youtubeVidJs.js')
            ->setTargetUri('assets/dist/youtubeVidJs.js')
            ->addJs('assets/js/vue-comp/YoutubeVid.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());

        $assetsManager->collection('vdNavBar')
            ->setTargetPath('assets/dist/vdNavBar.js')
            ->setTargetUri('assets/dist/vdNavBar.js')
            ->addJs('assets/js/vue-comp/VdNavBar.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());

        $assetsManager->collection('vdMessage')
            ->setTargetPath('assets/dist/vdMessage.js')
            ->setTargetUri('assets/dist/vdMessage.js')
            ->addJs('assets/js/vue-comp/VdMessage.js')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Jsmin());

        $assetsManager->collection('cssBase')
            ->setTargetPath('assets/dist/cssBase.css')
            ->setTargetUri('assets/dist/cssBase.css')
            ->addCss('assets/vuetify-v1.4.0-beta.0/vuetify-v1.4.0-beta.0.css')
            ->addCss('assets/css/app.css')
            ->join(true)
            ->addFilter(new Phalcon\Assets\Filters\Cssmin());

        $di->set('assets', $assetsManager);

        $this->setDI($di);
        echo $this->handle()->getContent();
    }
}

$application = new Application();
$application->main();
