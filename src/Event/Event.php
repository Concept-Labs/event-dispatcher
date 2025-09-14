<?php
namespace Concept\EventDispatcher\Event;

use Concept\EventDispatcher\Event\Context\EventContext;
use Concept\EventDispatcher\Event\Context\EventContextInterface;

class Event implements EventInterface
{

    protected ?EventContextInterface $context = null;
    protected bool $stopped = false;

    /**
     * Event constructor.
     *
     * @param array $context
     */
    public function __construct(array $context = [])
    {
        $this->getContext()->inflate($context);
    }

    /**
     * {@inheritDoc}
     */
    public function attach(string $id, mixed $contextValue): static
    {
        $this->getContext()->set($id, $contextValue);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContext(): EventContextInterface
    {
        return $this->context ??= new EventContext();
    }

    /**
     * {@inheritDoc}
     */
    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }

    /**
     * {@inheritDoc}
     */
    public function stopPropagation()
    {
        $this->setStopPropagation();
    }

    /**
     * Set stop propagation
     * Set stop propagation
     *
     * @param bool $stop
     *
     * @return static
     */
    protected function setStopPropagation(bool $stop = true): static
    {
        $this->stopped = $stop;

        return $this;
    }
}