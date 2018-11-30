<?php

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

        $logger = $this->getDI()->get('log');

        $logger->info('beforeException Shared '.$dispatcher->getModuleName());

		if ($exception instanceof DispatcherException) {
			switch ($exception->getCode()) {
				case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
				case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $logger->info('notFound ');
					$dispatcher->forward(
						[
						    'module' => 'site',
							'controller' => 'error',
							'action'     => 'notFound'
						]
					);
					return false;
			}
		}

        $logger->info('genericError ');
		$dispatcher->forward(
			[
                'module' => 'site',
				'controller' => 'error',
				'action'     => 'genericError',
			]
		);

		return false;
	}
}
