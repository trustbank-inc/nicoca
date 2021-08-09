<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

final class IntegerValueMock
{
    use IntegerValue {
        isValidValue as private _isValidValue;
    }

    private static function getMinValue(): int
    {
        return 100;
    }

    private static function getMaxValue(): int
    {
        return 9999;
    }

    private static function isValidValue(int $value): bool
    {
        return self::_isValidValue($value) && $value !== 7;
    }
}
