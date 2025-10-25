<?php
namespace Concept\EventDispatcher\Contract;

interface EventListenerInterface extends EventBusAwareInterface
{
    /**
     * Handle an event
     * 
     * @param object $event The event
     * 
     * @return void
     */
    public function __invoke(object $event): void;


    /**
     * Listen to an event type
     * 
     * @param string $type The event type
     * 
     * @return static
     */
    public function listen(string $type): static;
}