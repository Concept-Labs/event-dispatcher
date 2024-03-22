<?php
namespace Ctl\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Ctl\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{

    /**
     * @var ListenerProviderInterface[] The listener providers
     */
    protected array $providers = [];

    /**
     * {@inheritDoc}
     */
    public function addProvider(ListenerProviderInterface $listener): void
    {
        $this->providers[] = $listener;
    }
    
    /**
     * {@inheritDoc}
     */
    public function dispatch(object $event)
    {
        foreach ($this->providers as $provider) {
            foreach ($provider->getListenersForEvent($event) as $listener) {
                if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                    return $event;
                }
                //@TODO:VG try-catch
                //try {
                    //call_user_func_array($listener, [$event]); //php7.4 compability
                    $listener($event);
                //} 
            }
        }
    }

}