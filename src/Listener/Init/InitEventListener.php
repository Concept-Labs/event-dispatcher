<?php
namespace Concept\EventDispatcher\Listener\Init;

use Concept\EventDispatcher\Listener\AbstractListener;

/**
 * This listener is called on the init event of the event bus to be sure the event bus is initialized
 * in another case exception will be thrown indicating the event bus is not initialized
 */
class InitEventListener extends AbstractListener
{
    public function handle(object $event): void
    {
        //EventDispatcher initialized
    }
}