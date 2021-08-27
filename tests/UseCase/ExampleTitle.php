<?php
declare(strict_types=1);

namespace Tests\UseCase;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

final class ExampleTitle
{
    use StringValue;

    private static function getMinLength(): int
    {
        return 5;
    }

    private static function getMaxLength(): int
    {
        return 10;
    }
}