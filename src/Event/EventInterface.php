<?php
namespace Ctl\EventDispatcher\Event;


use Psr\EventDispatcher\StoppableEventInterface;

interface EventInterface Extends StoppableEventInterface
{
    public function getContext();

    public function setStopPropagation(bool $stop = true);
}