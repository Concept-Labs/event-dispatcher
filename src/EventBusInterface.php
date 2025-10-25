<?php
namespace Concept\EventDispatcher;

use Concept\EventDispatcher\Event\EventInterface;

interface EventBusInterface
{

    const CONFIG_NODE = 'event-bus';
    const CONFIG_NODE_LISTENERS = 'listeners';

    /**
     * @deprecated Use listen() instead
     * Register a listener to an event type
     * 
     * @param string $type The event type
     * @param callable $listener The listener
     * @param int $priority The priority
     * 
     * @return static
     */
    public function register(string $type, callable $listener, int $priority = 0): static;


    /**
     * Register a listener to an event type
     * 
     * @param string $type The event type
     * @param callable $listener The listener
     * @param int $priority The priority
     * 
     * @return static
     */
    public function listen(string $type, callable $listener, int $priority = 0): static;

    /**
     * Dispatch an event
     * 
     * @param EventInterface|string $event The event or event service id (class name or registered service id)
     * @param array $context The event context
     * 
     * @return EventInterface
     */
    public function dispatch(EventInterface|string $event, array $context = []): EventInterface;

}