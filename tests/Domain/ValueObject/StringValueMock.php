<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

final class StringValueMock
{
    use StringValue;

    private static function getMinLength(): int
    {
        return 3;
    }

    private static function getMaxLength(): int
    {
        return 20;
    }

    private static function isValidValue(string $value): bool
    {
        return !str_contains(haystack: $value, needle: '**INVALID**');
    }
}
