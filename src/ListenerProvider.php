<?php
declare(strict_types=1);
namespace Cl\EventDispatcher;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;

use Stringable;

class ListenerProvider implements ListenerProviderInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected array $container = [];
    protected int $serial = PHP_INT_MAX;

    protected array $cacheContainer = [];

    protected CacheInterface $cache = null;

    const DEFAULT_PRIORITY = 0;

    public function __construct(?CacheInterface $cache = null, ?LoggerInterface $logger = null)
    {
        $this->cache = $cache;
        $this->logger = $logger ?? new NullLogger;
    }

    public function getListenersForEvent(object $event): iterable
    {
        $eventIds = array_unique(
            array_values(
                [$event::class] + class_implements($event)
            )
        );

        $cacheKey = implode("_", $eventIds);
        if (null !== $cached = $this->fromCache($cacheKey)) {
            return $cached;
        }
        
        $listenersForEvent = [];
        foreach ($eventIds as $eventId) {
            if (!empty($this->container[$eventId])) {
                $listenersForEvent += array_values($this->container[$eventId]);
            }
        }

        $this->toCache($cacheKey, $listenersForEvent);

        return $listenersForEvent;
    }

    public function attach(object|string $event, callable $listener, ?int $priority = null)
    {
        $priority ??= static::DEFAULT_PRIORITY;
        $eventId = match (true) {
            is_object($event) => $event::class,
            default => (string) $event,
        };
        if (empty($this->container[$eventId])) {
            $this->container[$eventId] = [];
        }
        $this->container[$eventId][$priority][--$this->serial] = $listener;
        
        $this->sort();
    }

    protected function sort(): void
    {
        foreach ($this->container as $eventId => $listeners) {
            krsort($this->container[$eventId]);
        }
    }

    protected function toCache(string $cacheKey, mixed $value ): void
    {
        match (true) {
            null !== $this->cache && $this->cache instanceof CacheInterface => $this->cache->set($cacheKey, $value),
            default => $this->cacheContainer[$cacheKey] = $value,
        };
    }
    protected function fromCache(string $cacheKey): mixed
    {
        return match (true) {
            null !== $this->cache && $this->cache instanceof CacheInterface => $this->cache->get($cacheKey),
            !empty($this->cacheContainer[$cacheKey]) => $this->cacheContainer[$cacheKey],
            default => null,
        };
    }


}