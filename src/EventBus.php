<?php
namespace Concept\EventDispatcher;

use Concept\EventDispatcher\Event\EventFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

use Concept\EventDispatcher\Event\EventInterface;
use Concept\EventDispatcher\Listener\ListenerRegistryInterface;
use Concept\Singularity\Contract\Lifecycle\SharedInterface;

class EventBus implements EventBusInterface, SharedInterface
{
    public function __construct(
        private ListenerProviderInterface $listenerRegistry,
        private EventDispatcherInterface $eventDispatcher,
        private EventFactoryInterface $eventFactory
        //private ConfigInterface $config
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
    public function listen(string $type, callable $listener, int $priority = 0): static
    {
        $this->getRegistry()->register($type, $listener, $priority);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function dispatch(EventInterface|string $event, array $context = []): EventInterface
    {
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }

        if (is_string($event)) {
            $event = $this->getEventFactory()->create($event);
        }

        if (!empty($context)) {
            $event->getContext()->inflate($context);
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

    protected function getEventFactory(): EventFactoryInterface
    {
        return $this->eventFactory;
    }
}