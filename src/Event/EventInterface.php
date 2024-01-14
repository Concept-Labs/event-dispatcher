<?php
declare(strict_types=1);
namespace Cl\EventDispatcher\Event;

interface EventInterface
{
    //function isStoppable(): bool;
    //function getCode();
    //function 

    /**
     * Sets a context
     *
     * @param mixed $context
     * @return void
     */
    function setContext(mixed $context): void;

    /**
     * Gets a context
     *
     * @return mixed
     */
    function getContext(): mixed;
}