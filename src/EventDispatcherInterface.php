<?php
namespace Ctl\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

interface EventDispatcherInterface extends PsrEventDispatcherInterface
{

    /**
     * Adds the listener provider
     *
     * @param ListenerProviderInterface $listener
     * 
     * @return void
     */
    public function addProvider(ListenerProviderInterface $listener): void;

}