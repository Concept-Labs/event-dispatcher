<?php
namespace Concept\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherAwareTrait
{
    protected ?EventDispatcherInterface $___eventDispatcher = null;

    /**
     * Set an event dispatcher
     *
     * @param EventDispatcherInterface $eventDispatcher The dispatcher
     * 
     * @return void
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->___eventDispatcher = $eventDispatcher;
    }

    /**
     * Get the event dispatcher
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->___eventDispatcher;
    }

}