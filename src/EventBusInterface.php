<?php
namespace Concept\EventDispatcher;

use Concept\EventDispatcher\Event\EventInterface;

interface EventBusInterface
{
    /**
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
     * Unregister a listener from an event type
     * 
     * @param string $type The event type
     * @param callable $listener The listener
     * 
     * @return static
     */
    public function unregister(string $type, callable $listener): static;

    /**
     * Dispatch an event
     * 
     * @param EventInterface $event The event
     * 
     * @return static
     */
    public function dispatch(EventInterface $event): static;

}