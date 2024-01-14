<?php
namespace Cl\EventDispatcher\Test\Asset;

class EventTestStoppable extends EventTest {
    public bool $stopped = false;
    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }
    
}