<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Infrastructure\Persistence;

use Closure;
use InvalidArgumentException;
use Seasalt\Nicoca\Components\Domain\EventChannel;

class EntityRepositoryImpl
{
    protected function __construct(
        protected readonly EventChannel $eventChannel,
        protected readonly string $entity,
    )
    {
        if ($entity === '') {
            throw new InvalidArgumentException('entity name is required');
        }
    }

    final protected function createRecordFromEntity(mixed $entity): mixed
    {
        return Closure::bind(function() use ($entity) {
            return $entity->toPersistenceRecord();
        }, null, $this->entity)();
    }

    final protected function restoreEntity(mixed $record): mixed
    {
        $eventChannel = $this->eventChannel;
        $className = $this->entity;
        return Closure::bind(function() use ($className, $eventChannel, $record) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $className::restore($eventChannel, $record);
        }, null, $this->entity)();
    }
}
