<?php
namespace Ctl\EventDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherAwareTrait
{
    protected ?EventDispatcherInterface $eventDispatcher = null;

    /**
     * Set an event dispatcher
     *
     * @param EventDispatcherInterface $eventDispatcher The dispatcher
     * 
     * @return void
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

}