<?php
declare(strict_types=1);
namespace Cl\EventDispatcher\Event;

use Cl\Able\Contextable\ContextableInterface;
use Cl\Able\Contextable\ContextableTrait;

class Event implements EventInterface, ContextableInterface
{
    use ContextableTrait;
}