<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Infrastructure\Persistence;

use Closure;
use IteratorIterator;
use Seasalt\Nicoca\Components\Domain\EventChannel;
use Traversable;

class EntityIterator extends IteratorIterator
{
    public function __construct(
        private readonly EventChannel $eventChannel,
        private readonly string $entity,
        Traversable $records,
    )
    {
        parent::__construct($records);
    }

    public function current(): mixed
    {
        $className = $this->entity;
        $eventChannel = $this->eventChannel;
        $record = parent::current();
        return Closure::bind(function() use ($className, $eventChannel, $record) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $className::restore($eventChannel, $record);
        }, null, $className)();
    }
}
