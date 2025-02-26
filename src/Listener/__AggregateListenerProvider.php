<?php
namespace Concept\EventDispatcher\ListenerProvider;

use Psr\EventDispatcher\ListenerProviderInterface;

class AggregateListenerProvider implements ListenerProviderInterface
{
    /**
     * @var ListenerProviderInterface[] Список провайдерів
     */
    protected array $providers = [];

    /**
     * Add a provider to the aggregate
     * 
     * @param ListenerProviderInterface $provider
     * 
     * @return static
     */
    public function addProvider(ListenerProviderInterface $provider): static
    {
        $this->providers[] = $provider;
        
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getListenersForEvent(object $event): iterable
    {
        foreach ($this->providers as $provider) {
            yield from $provider->getListenersForEvent($event);
        }
    }
}
