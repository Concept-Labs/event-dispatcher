<?php

namespace Cl\EventDispatcher\Test\Dispatcher;

use PHPUnit\Framework\TestCase;
use Cl\EventDispatcher\EventDispatcher;
use Cl\EventDispatcher\Dispatcher\Exception\EventPropagationIsStoppedException;
use Cl\EventDispatcher\Test\Asset\EventTest;

use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Psr\Log\LoggerInterface;

/**
 * @covers Cl\EventDispatcher\EventDispatcher
 */
class EventDispatcherTest extends TestCase
{
    // Тест на додавання та виклик слухача
    public function testAddAndDispatchListener()
    {
        $listenerProvider = $this->createMock(ListenerProviderInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $eventDispatcher = new EventDispatcher($listenerProvider, null, $logger);

        
        $event = new EventTest();
        $listener = function ($event) {
            $event->handled = true;
        };
        $listenerProvider->method('getListenersForEvent')->willReturn([$listener]);

        
        $resultEvent = $eventDispatcher->dispatch($event);

        
        $this->assertTrue($event->handled);
        
        $this->assertSame($event, $resultEvent);
    }

    public function testEventPropagationIsStopped()
    {
        $listenerProvider = $this->createMock(ListenerProviderInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $eventDispatcher = new EventDispatcher($listenerProvider, null, $logger);

        $event = new class implements StoppableEventInterface {
            public bool $stopped = false;
            public string $property = 'not handled';
            function isPropagationStopped(): bool {
                return $this->stopped;
            }
        };
        $listener = function ($event) {
            $event->stopped = true;
        };
        $listener2 = function ($event) {
            $event->property = 'handled by listener2';
        };
        $listenerProvider->method('getListenersForEvent')->willReturn([$listener, $listener2]);

        $resultEvent = $eventDispatcher->dispatch($event);

        $this->assertEquals('not handled', $event->property);
        $this->assertSame($event, $resultEvent);
    }

    public function testEventPropagationIsStoppedExceptionInsideListener()
    {
        $listenerProvider = $this->createMock(ListenerProviderInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $eventDispatcher = new EventDispatcher($listenerProvider, null, $logger);

        
        $listener = function ($event) {
            throw new EventPropagationIsStoppedException();
        };
        $listener = function ($event) {
            throw new EventPropagationIsStoppedException();
        };
        $listenerProvider->method('getListenersForEvent')->willReturn([$listener]);

        $resultEvent = $eventDispatcher->dispatch($event);

        $this->assertSame($event, $resultEvent);
    }

}
