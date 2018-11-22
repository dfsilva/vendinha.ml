<?php

error_reporting(E_ALL);

use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
     */
    protected function registerServices(\Phalcon\Config $config = null)
    {

        $di = new FactoryDefault();
        $di->set('config', $config);

        $loader = new Loader();

        /**
         * We're a registering a set of directories taken from the configuration file
         */
        $loader->registerDirs([__DIR__ . '/../apps/shared/library/',
                __DIR__ . '/../apps/shared/plugins/'])->register();

        // Registering a router
        $di->set('router', function () {

            $router = new Router();

            $router->setDefaultModule("site");

            $router->add('/:controller/:action', [
                'module' => 'site',
                'controller' => 1,
                'action' => 2,
            ])->setName('site');

//            $router->add("/login", [
//                'module'     => 'backend',
//                'controller' => 'login',
//                'action'     => 'index',
//            ])->setName('backend-login');
//
//            $router->add("/admin/products/:action", [
//                'module'     => 'backend',
//                'controller' => 'products',
//                'action'     => 1,
//            ])->setName('backend-product');
//
//            $router->add("/products/:action", [
//                'module'     => 'frontend',
//                'controller' => 'products',
//                'action'     => 1,
//            ])->setName('frontend-product');

            return $router;
        });

        $this->setDI($di);
    }

    public function initVariables()
    {
        define('DB_HOST', getenv('DB_HOST'));
        define('DB_USER', getenv('DB_USER'));
        define('DB_PASSWORD', getenv('DB_PASSWORD'));
        define('DB_NAME', getenv('DB_NAME'));
        define('APP_DEBUG', getenv('APP_DEBUG'));
        define('APP_PUBLIC_URL', getenv('APP_PUBLIC_URL'));
    }

    public function main()
    {
        $this->initVariables();

        if (APP_DEBUG) {
            $debug = new Phalcon\Debug();
            $debug->listen();
        }

        $config = include __DIR__ . '../apps/shared/config/conf.php';

        $this->registerServices($config);

        // Register the installed modules
        $this->registerModules([
//            'api'  => [
//                'className' => 'Vendinha\Api\Module',
//                'path'      => '../apps/api/Module.php'
//            ],
            'site' => [
                'className' => 'Vendinha\Site\Module',
                'path' => '../apps/site/Module.php'
            ]
        ]);

        echo $this->handle()->getContent();
    }
}

$application = new Application();
$application->main();
