<?php
namespace Concept\EventDispatcher\Contract;

use Concept\EventDispatcher\EventBusInterface;

interface EventBusAwareInterface
{
    /**
     * Set the event bus
     * 
     * @param EventBusInterface $eventBus The event bus
     * 
     * @return static
     */
    public function setEventBus(EventBusInterface $eventBus): static;

    /**
     * Get the event bus
     * 
     * @return EventBusInterface
     */
    public function getEventBus(): EventBusInterface;
}