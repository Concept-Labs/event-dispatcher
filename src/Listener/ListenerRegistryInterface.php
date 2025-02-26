<?php
namespace Concept\EventDispatcher\Listener;

use Psr\EventDispatcher\ListenerProviderInterface;

interface ListenerRegistryInterface extends ListenerProviderInterface
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
     * Get the listeners for an event
     * 
     * @param object $event The event
     * 
     * @return iterable The listeners
     */
    public function getListenersForEvent(object $event): iterable;
}