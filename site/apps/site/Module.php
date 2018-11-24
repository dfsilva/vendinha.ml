<?php

namespace Vendinha\Site;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'Vendinha\Site\Controllers' => __DIR__ . '/controllers/'
            ]
        );

        $loader->register();
    }


    public function registerServices(DiInterface $di)
    {
        $config = $di->get('config');

        $di['dispatcher'] = function () {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Vendinha\Site\Controllers');
            return $dispatcher;
        };

        $di['view']->setViewsDir(
            __DIR__ . '/views'
        );

        $di['router']->add('/test', [
            'module' => 'site',
            'controller' => 'index',
            'action' => 'test'
        ]);

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
