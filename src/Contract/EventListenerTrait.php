<?php
namespace Concept\EventDispatcher\Contract;

trait EventListenerTrait
{
    /**
     * {@inheritDoc}
     */
    public function listen(string $type): static
    {
        $this->getEventBus()->register($type, $this);

        return $this;
    }
}