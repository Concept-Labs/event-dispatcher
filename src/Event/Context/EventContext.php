<?php
namespace Concept\EventDispatcher\Event\Context;

class EventContext implements EventContextInterface
{
    /**
     * The context
     *
     * @var array
     */
    protected array $context = [];

    /**
     * {@inheritDoc}
     */
    public function set(string $id, mixed $value): static
    {
        $this->context[$id] = $value;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple(array $values): static
    {
        foreach ($values as $id => $value) {
            $this->set($id, $value);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $id): mixed
    {
        return $this->context[$id] ?? null;
    }
}