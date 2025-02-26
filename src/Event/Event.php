<?php
namespace Concept\EventDispatcher\Event;

use Concept\EventDispatcher\Event\Context\EventContext;
use Concept\EventDispatcher\Event\Context\EventContextInterface;

class Event implements EventInterface
{

    protected ?EventContextInterface $context = null;
    protected bool $stopped = false;

    public function __construct(array $context = [])
    {
        $this->getContext()->setMultiple($context);
    }

    public function attach(string $id, mixed $contextValue): static
    {
        $this->getContext()->set($id, $contextValue);

        return $this;
    }


    public function getContext(): EventContextInterface
    {
        return $this->context ??= new EventContext();
    }

    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }

    public function setStopPropagation(bool $stop = true)
    {
        $this->stopped = $stop;
    }

    public function stopPropagation()
    {
        $this->setStopPropagation();
    }
}