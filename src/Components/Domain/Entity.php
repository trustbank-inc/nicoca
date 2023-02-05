<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain;

abstract class Entity
{
    protected function __construct(
        private readonly EventChannel $eventChannel,
    )
    {

    }

    final protected function publish($event): void
    {
        $this->eventChannel->publish($event);
    }

    abstract protected function toPersistenceRecord(): mixed;
}
