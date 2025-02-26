<?php
namespace Concept\EventDispatcher\Event\Context;

interface EventContextInterface
{
    /**
     * Add a value to the context
     * 
     * @param string $id The id
     * @param mixed $value The value
     * 
     * @return static
     */
    public function set(string $id, mixed $value): static;

    /**
     * Add multiple values to the context
     * 
     * @param array $values The values
     * 
     * @return static
     */
    public function setMultiple(array $values): static;

    /**
     * Get a value from the context
     * 
     * @param string $id The id
     * 
     * @return mixed
     */
    public function get(string $id): mixed;
}