<?php
namespace Ctl\EventDispatcher\Event;

class Event implements EventInterface
{
    protected array $context = [];

    protected bool $stopped = false;

    public function __construct(array $context = [])
    {
        $this->context = $context;
    }

    public function setContext(array $context): void
    {
        $this->context = $context;
    }

    public function withContext(array $context): EventInterface
    {
        $event = clone $this;
        $event->setContext($context);

        return $event;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }

    public function setStopPropagation(bool $stop = true)
    {
        $this->stopped = $stop;
    }
}