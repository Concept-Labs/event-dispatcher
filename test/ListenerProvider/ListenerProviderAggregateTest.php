<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Cl\EventDispatcher\Listener\ListenerProviderAggregate;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * @covers \Cl\EventDispatcher\ListenerProvider\ListenerProviderAggregate
 */
class ListenerProviderAggregateTest extends TestCase
{

    private $_listenerProviderAggregate;
    protected function setUp(): void
    {
        $this->_listenerProviderAggregate = new ListenerProviderAggregate();
    }
    public function testInstance()
    {
        $this->assertInstanceOf(ListenerProviderAggregate::class, $this->_listenerProviderAggregate);
    }

    public function testIteratorAggregateGetIterator()
    {
        $this->assertIsIterable($this->_listenerProviderAggregate);
    }

    public function testAttachAndDetach()
    {
        $provider1 = $this->createMock(ListenerProviderInterface::class);
        $provider2 = $this->createMock(ListenerProviderInterface::class);

        $aggregate = new ListenerProviderAggregate($provider1);
        $this->assertCount(1, $aggregate->getProviders());

        $aggregate->attach($provider2);
        $this->assertCount(2, $aggregate->getProviders());

        $aggregate->detach($provider1);
        $this->assertCount(1, $aggregate->getProviders());
    }

    public function testGetListenersForEvent()
    {
        $event = $this->createMock(\stdClass::class);

        $provider1 = $this->createMock(ListenerProviderInterface::class);
        $provider1->expects($this->once())->method('getListenersForEvent')->with($event)->willReturn([1, 2]);

        $provider2 = $this->createMock(ListenerProviderInterface::class);
        $provider2->expects($this->once())->method('getListenersForEvent')->with($event)->willReturn([3, 4]);

        $aggregate = new ListenerProviderAggregate($provider1, $provider2);

        $listeners = iterator_to_array($aggregate->getListenersForEvent($event));

        $this->assertEquals([1, 2, 3, 4], $listeners);
    }
}