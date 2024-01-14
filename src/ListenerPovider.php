<?php
declare(strict_types=1);
namespace Cl\EventDispatcher;

use Cl\EventDispatcher\Listener\Exception\ListenerDuplicateException;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;


class ListenerPovider extends \SplPriorityQueue implements ListenerProviderInterface
{
    private array $listeners = [];

    public function construct(LoggerInterface $logger = null)

    public function addListener(object $event, callable $listener): bool
    {
        if (array_search($listener, $this->listeners, true)) {
            return false;
            throw new ListenerDuplicateException(_('Tried to add the listener duplicate'));
        }
        $this->listeners[$event::class][] = $listener;
        return true;
    }

    public function removeListener(object $event, callable $listener): bool
    {

    }

    public function getListenersForEvent(object $event): iterable
    {

    }
}