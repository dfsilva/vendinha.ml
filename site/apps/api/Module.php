<?php

/**
 * @author Diego Silva
 */

namespace Vendinha\Api;

use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Vendinha\Api\Plugins\NotFoundPlugin;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class Module implements ModuleDefinitionInterface {

    public function registerAutoloaders(\Phalcon\DiInterface $di = NULL) {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(
            [
                'Vendinha\Api\Controllers' => __DIR__ . '/controllers/',
                'Vendinha\Api\Plugins' => __DIR__ . '/plugins/'
            ]
        );
        $loader->register();
    }

    public function registerServices(\Phalcon\DiInterface $di) {

//        $dispatcher = $di->get('dispatcher');
//        $dispatcher->setDefaultNamespace("Vendinha\Api\Controllers");
//        $security = new \all\plugins\ApiSecurity($di);
//        $dispatcher->getEventsManager()->attach('dispatch', $security);
//        $di->set('dispatcher', $dispatcher);
        $di['log']->info('Module Api');

        $di->set('dispatcher', function () {
            $dispatcher = new MvcDispatcher();
            $eventsManager = new EventsManager;
            $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace('Vendinha\Api\Controllers');
            return $dispatcher;
        });


//        $dispatcher = $di->get('dispatcher');
//        $dispatcher->setDefaultNamespace("Vendinha\Api\Controllers");
//        $dispatcher->getEventsManager()->attach('dispatch:beforeException', new NotFoundPlugin);
//        $di->set('dispatcher', $dispatcher);


        $view = new View;
        $view->disable();
        $di->set('view', $view);

//        $view = $di->get('view');
//        $view->disable();
//        $di['view']->disable();
//        $di->set('view', $view);
    }
}
