<?php
namespace Ctl\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

trait ListenerProviderAwareTrait
{
    protected ?ListenerProviderInterface $listenerProvider = null;

    /**
     * Set a listener provider
     *
     * @param ListenerProviderInterface $listenerProvider The provider
     * 
     * @return void
     */
    public function setListenerProvider(ListenerProviderInterface $listenerProvider): void
    {
        $this->listenerProvider = $listenerProvider;
    }
    
}