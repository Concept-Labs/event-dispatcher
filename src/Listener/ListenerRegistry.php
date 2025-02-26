<?php

namespace Concept\EventDispatcher\Listener;

use Concept\Singularity\Contract\Behavior\ResetableInterface;
use Concept\Singularity\Contract\Lifecycle\PrototypeInterface;
use Concept\Singularity\Plugin\Attribute\Plugin;
use Concept\Singularity\Plugin\ContractEnforce\Common\CommonTest;
use Concept\Singularity\Plugin\ContractEnforce\Enforcement;

#[Plugin(CommonTest::class, false)]
#[Plugin(Enforcement::class, false)]
class ListenerRegistry 
    implements 
    ListenerRegistryInterface,
    ResetableInterface,
    PrototypeInterface

{
    /**
     * The listeners
     *
     * @var array<string, array{priority: int, listener: callable}[]> The callable listener
     */
    protected array $listeners = [];

    /**
     * {@inheritDoc}
     */
    public function prototype(): static
    {
        return (clone $this)->reset();
    }

    /**
     * {@inheritDoc}
     */
    public function reset(): static
    {
        $this->listeners = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function register(string $type, callable $listener, int $priority = 0): static
    {
        $this->listeners[$type][] = ['priority' => $priority, 'listener' => $listener];

        usort($this->listeners[$type], fn($a, $b) => $b['priority'] <=> $a['priority']);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function unregister(string $type, callable $listener): static
    {
        if (!isset($this->listeners[$type])) {
            return $this;
        }

        foreach ($this->listeners[$type] as $i => $entry) {
            if ($entry['listener'] === $listener) {
                unset($this->listeners[$type][$i]);
            }
        }

        $this->listeners[$type] = array_values($this->listeners[$type]);

        if (empty($this->listeners[$type])) {
            unset($this->listeners[$type]);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getListenersForEvent(object $event): iterable
    {
        $types = [get_class($event)] + class_implements($event);

        foreach ($types as $type) {
            if (!isset($this->listeners[$type])) {
                continue;
            }

            foreach ($this->listeners[$type] as $entry) {
                yield $entry['listener'];
            }
        }
    }
}
