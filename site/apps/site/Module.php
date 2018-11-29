<?php

namespace Vendinha\Site;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\View\Engine\Php as PhpViewEngine;
use Phalcon\DiInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Vendinha\Site\Plugins\NotFoundPlugin;


class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'Vendinha\Site\Controllers' => __DIR__ . '/controllers/',
                'Vendinha\Site\Plugins' => __DIR__ . '/plugins/'
            ]
        );

        $loader->register();
    }


    public function registerServices(DiInterface $di)
    {
        $config = $di->get('config');

        $di->set('dispatcher', function () {
            $dispatcher = new MvcDispatcher();
            $eventsManager = new EventsManager;
            $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Vendinha\Site\Controllers');
            return $dispatcher;
        });

        $view = new View;

        $view->setLayoutsDir(__DIR__ . '/../../apps/layouts/');
        $view->setPartialsDir(__DIR__ . '/../../apps/partials/');
        //        $view->setLayout($config->view->defaultLayout); // default layout
        $view->setViewsDir(
            __DIR__ . '/views'
        );

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

//        $di['view']->setViewsDir(
//            __DIR__ . '/views'
//        );


//        $di->set('db', function () {
//            return new Mysql(
//                [
//                    "host" => "amazon",
//                    "username" => "root",
//                    "password" => "Diego2356",
//                    "dbname" => "vendinha"
//                ]
//            );
//        });
    }
}
