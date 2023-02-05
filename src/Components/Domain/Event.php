<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain;

use DateTimeImmutable;

class Event
{
    public readonly DateTimeImmutable $occurredOn;

    public function __construct()
    {
        $this->occurredOn = new DateTimeImmutable();
    }
}
