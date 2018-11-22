<?php

namespace Vendinha\Site;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'Vendinha\Site\Controllers' => '../apps/site/controllers/'
            ]
        );

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $config = $di->get('config');

        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $dispatcher = new Dispatcher();

            $eventManager = new Manager();

            // Attach a event listener to the dispatcher (if any)
            // For example:
            // $eventManager->attach('dispatch', new \My\Awesome\Acl('frontend'));

            $dispatcher->setEventsManager($eventManager);
            $dispatcher->setDefaultNamespace('Vendinha\Site\Controllers');
            return $dispatcher;
        });

        // Registering the view component
        $di->set(
            "view",
            function () use ($config) {
                $view = new View();

                $view->setViewsDir(
                    $config->application->viewsDir
                );

                $view->registerEngines(
                    [
                        ".volt" => function ($view, $di) use ($config) {
                            $volt = new VoltEngine($view, $di);

                            $volt->setOptions(
                                [
                                    "compiledPath"      => $config->application->cacheDir,
                                    "compiledSeparator" => "_",
                                ]
                            );

                            return $volt;
                        },

                        // Generate Template files uses PHP itself as the template engine
                        ".phtml" => PhpViewEngine::class
                    ]
                );

                return $view;
            },
            true
        );

        $di->set('db', function () {
            return new Mysql(
                [
                    "host" => "amazon",
                    "username" => "root",
                    "password" => "Diego2356",
                    "dbname" => "vendinha"
                ]
            );
        });
    }
}
