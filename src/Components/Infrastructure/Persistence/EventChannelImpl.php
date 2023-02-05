<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Infrastructure\Persistence;

use Seasalt\Nicoca\Components\Domain\Event;
use Seasalt\Nicoca\Components\Domain\EventChannel;

final class EventChannelImpl implements EventChannel
{
    public function publish(Event $event): void
    {
        event($event);
    }
}
