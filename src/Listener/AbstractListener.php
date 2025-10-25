<?php

namespace Concept\EventDispatcher\Listener;

use Concept\EventDispatcher\Contract\EventBusAwareTrait;
use Concept\EventDispatcher\Contract\EventListenerInterface;
use Concept\EventDispatcher\Contract\EventListenerTrait;

abstract class AbstractListener implements EventListenerInterface
{
    use EventBusAwareTrait;
    use EventListenerTrait;

    public function __invoke(object $event): void
    {
        $this->handle($event);
    }

    abstract public function handle(object $event): void;

}