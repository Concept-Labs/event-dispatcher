<?php
declare(strict_types=1);
namespace Cl\EventDispatcher\Event;

class StoppableEvent extends Event implements StoppableEventInterface
{
    /**
     * The event propgatation stop flag
     *
     * @var boolean
     */
    protected $isStopped = false;

    /**
     * {@inheritDoc}
     */
    public function isPropagationStopped() : bool
    {
        return $this->$isStopped
    }

    /**
     * {@inheritDoc}
     */
    public function setPropagationStopped(bool $isStopped = true): void
    {
        $this->$isStopped = $isStopped;
    }
}