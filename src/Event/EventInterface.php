<?php
namespace Concept\EventDispatcher\Event;

use Concept\EventDispatcher\Event\Context\EventContextInterface;
use Psr\EventDispatcher\StoppableEventInterface;

interface EventInterface Extends StoppableEventInterface
{

    /**
     * Attach a value to the event context
     *
     * @param string $id
     * @param mixed $contextValue
     * @return static
     */
    public function attach(string $id, mixed $contextValue): static;

    /**
     * Get the event name
     *
     * @return EventContextInterface The event context
     */
    public function getContext(): EventContextInterface;

    /**
     * Set the event name
     *
     * @param string $context The event name
     * 
     * @return void
     */
    public function setStopPropagation(bool $stop = true);

    /**
     * Stop propagation
     *
     * @return void
     */
    public function stopPropagation();
}