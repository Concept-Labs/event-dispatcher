<?php
namespace Concept\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Concept\EventDispatcher\Event\EventInterface;
use Concept\EventDispatcher\Listener\ListenerRegistryInterface;
use Concept\Singularity\Contract\Lifecycle\SharedInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Concept\Singularity\Contract\Factory\LazyGhostInterface;

class EventBus implements EventBusInterface, SharedInterface
{
    public function __construct(
        private ListenerProviderInterface $listenerRegistry,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function register(string $type, callable $listener, int $priority = 0): static
    {
        $this->getRegistry()->register($type, $listener, $priority);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function unregister(string $type, callable $listener): static
    {
        $this->getRegistry()->unregister($type, $listener);
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(EventInterface $event): EventInterface
    {
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }

        $this->getEventDispatcher()->dispatch($event);
        
        return $event;
    }

    /**
     * Get the listener registry
     * 
     * @return ListenerRegistryInterface
     */
    protected function getRegistry(): ListenerRegistryInterface
    {
        return $this->listenerRegistry;
    }

    /**
     * Get the event dispatcher
     * 
     * @return EventDispatcherInterface
     */
    protected function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }
}