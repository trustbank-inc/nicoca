<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain;

use Closure;
use Seasalt\Nicoca\Components\Domain\Persistence\IdGenerator;

class EntityFactory
{
    public function __construct(
        private readonly EventChannel $eventChannel,
        private readonly IdGenerator $idFactory,
    )
    {

    }

    final protected function createEntity(string $className, ...$params): mixed
    {
        $eventChannel = $this->eventChannel;
        $id = $this->idFactory->generate();
        return Closure::bind(function() use ($className, $eventChannel, $id, $params) {
            /** @noinspection PhpUndefinedMethodInspection */
            return $className::create($eventChannel, $id, ...$params);
        }, null, $className)();
    }
}
