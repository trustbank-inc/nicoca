<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain;

interface EventChannel
{
    public function publish(Event $event): void;
}
