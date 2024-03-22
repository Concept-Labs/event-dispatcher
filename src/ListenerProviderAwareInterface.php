<?php
namespace Ctl\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

interface ListenerProviderAwareInterface
{
    
    /**
     * Set a listener provider
     *
     * @param ListenerProviderInterface $listenerProvider The provider
     * 
     * @return void
     */
    public function setListenerProvider(ListenerProviderInterface $listenerProvider): void;
    
}