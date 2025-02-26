<?php

namespace Concept\EventDispatcher\Listener;

use Concept\EventDispatcher\Contract\EventBusAwareTrait;
use Concept\EventDispatcher\Contract\EventListenerTrait;
use Concept\EventDispatcher\Contract\EventListenterInterface;

abstract class AbstractListener implements EventListenterInterface
{
    use EventBusAwareTrait;
    use EventListenerTrait;

    public function __invoke(object $event): void
    {
        $this->handle($event);
    }

    abstract public function handle(object $event): void;

}