<?php

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\Application;
use Laminas\EventManager\EventManager;
use Application\Service\ProductService;
use Laminas\EventManager\EventInterface;
use Application\Events\ProductWasDisabled;
use Application\Controller\IndexController;
use Application\Listener\UpdateProductListener;
use Application\Listener\InsertProductListener;
use Application\Repository\LogProductRepository;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;

class Module implements BootstrapListenerInterface
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function onBootstrap(EventInterface $e)
    {
        /** @var Application $application */
        $application = $e->getApplication();

        /** @var EventManager $eventManager */
        $eventManager = $application->getEventManager();

        $configEvents = $application->getServiceManager()->get('config')['event_listeners'];
        foreach ($configEvents as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                $listener = $application->getServiceManager()->get($listener);
                $eventManager->getSharedManager()->attach(
                    '*',
                    $eventName,
                    $listener,
                    100
                );
            }
        }
    }
}
