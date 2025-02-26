<?php
namespace Concept\EventDispatcher\Contract;

use Concept\EventDispatcher\EventBusInterface;

trait EventBusAwareTrait
{

    protected EventBusInterface $___eventBus;

    /**
     * Set the event bus
     * 
     * @param EventBusInterface $eventBus The event bus
     * 
     * @return static
     */
    public function setEventBus(EventBusInterface $eventBus): static
    {
        $this->___eventBus = $eventBus;

        return $this;
    }

    /**
     * Get the event bus
     * 
     * @return EventBusInterface
     */
    public function getEventBus(): EventBusInterface
    {
        return $this->___eventBus;
    }
}