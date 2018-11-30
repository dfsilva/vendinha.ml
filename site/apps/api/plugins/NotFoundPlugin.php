<?php

namespace Vendinha\Api\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class NotFoundPlugin extends Plugin
{
	/**
	 * This action is executed before perform any action in the application
	 *
	 * @param Event $event
	 * @param MvcDispatcher $dispatcher
	 * @param \Exception $exception
	 * @return boolean
	 */
	public function beforeException(Event $event, MvcDispatcher $dispatcher, \Exception $exception)
	{
//		error_log($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());

        $this->getDI()->get('log')->info('beforeException API');


		if ($exception instanceof DispatcherException) {
			switch ($exception->getCode()) {
				case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
				case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
					$dispatcher->forward(
						[
							'controller' => 'error',
							'action'     => 'notFound',
                            'namespace' => 'Vendinha\Api\Controllers'
						]
					);
					return false;
			}
		}

		$dispatcher->forward(
			[
				'controller' => 'error',
				'action'     => 'genericError',
                'namespace' => 'Vendinha\Api\Controllers'
			]
		);

		return false;
	}
}
