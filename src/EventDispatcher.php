<?php
namespace Concept\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{

    /**
     * EventDispatcher constructor.
     * @param ListenerProviderInterface $provider
     */
    public function __construct(private ListenerProviderInterface $provider)
    {
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
        foreach ($this->provider->getListenersForEvent($event) as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                return $event;
            }
            try {
                $listener($event);
            } catch (\Throwable $e) {
                error_log("[EventDispatcher] Exception in event listener: " . $e->getMessage());
                throw $e;
            }
        }
        return $event;
    }
}
