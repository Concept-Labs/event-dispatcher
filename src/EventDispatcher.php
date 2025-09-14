<?php
namespace Concept\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Concept\Singularity\Contract\Lifecycle\SharedInterface;

class EventDispatcher implements EventDispatcherInterface, SharedInterface
{

    /**
     * EventDispatcher constructor.
     * @param ListenerProviderInterface $provider
     */
    public function __construct(private ListenerProviderInterface $provider)
    {
    }

    protected function getListenerProvider(): ListenerProviderInterface
    {
        return $this->provider;
    }

    /**
     * Dispatches an event to all registered listeners
     * 
     * @param object $event
     * 
     * @return object
     * 
     * @throws \Throwable
     */
    public function dispatch(object $event): object
    {
        foreach ($this->getListenerProvider()->getListenersForEvent($event) as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                return $event;
            }

            $listener($event);
        }
        
        return $event;
    }
}
