<?php

error_reporting(E_ALL);

use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View\Engine\Php as PhpViewEngine;

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

        $config = include __DIR__ . '/../apps/shared/config/conf.php';


        $di = new FactoryDefault();
        $di->set('config', $config);

        $this->registerModules([
//            'api'  => [
//                'className' => 'Vendinha\Api\Module',
//                'path'      => '../apps/api/Module.php'
//            ],
            'site' => [
                'className' => 'Vendinha\Site\Module',
                'path' => __DIR__ . '/../apps/site/Module.php'
            ]
        ]);


        $di['router'] = function () {

            $router = new \Phalcon\Mvc\Router();

            $router->add('/', [
                'module' => 'site',
                'controller' => 'index',
                'action' => 'index'
            ]);

            $router->add('/test', [
                'module' => 'site',
                'controller' => 'index',
                'action' => 'test'
            ]);

            return $router;
        };

        $view = new Phalcon\Mvc\View();

        $view->setLayoutsDir(__DIR__ . '/../apps/layouts/');
        $view->setPartialsDir(__DIR__ . '/../apps/partials/');
//        $view->setLayout($config->view->defaultLayout); // default layout

        $view->registerEngines(
            [
                ".volt" => function ($view, $di) use ($config) {
                    $volt = new VoltEngine($view, $di);
                    $volt->setOptions(
                        [
                            "compiledPath" => $config->application->cacheDir,
                            "compiledSeparator" => "_",
                        ]
                    );
                    return $volt;
                },
                ".phtml" => PhpViewEngine::class
            ]
        );

        $di->set('view', $view);

        $di->set('url', function () {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/');
            $url->setBasePath('/');

            return $url;
        }, true);

        $di->set('session', function () {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();

            return $session;
        });

        $this->setDI($di);


        echo $this->handle()->getContent();
    }
}

$application = new Application();
$application->main();
