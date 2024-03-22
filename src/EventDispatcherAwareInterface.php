<?php
namespace Ctl\EventDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherAwareInterface
{

    /**
     * Set an event dispatcher
     *
     * @param EventDispatcherInterface $eventDispatcher The dispatcher
     * 
     * @return void
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void;
    
}