<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Seasalt\Nicoca\Components\Domain\ValueObject\DecimalValue;

final class DecimalValueMock
{
    use DecimalValue {
        isValidValue as private _isValidValue;
    }

    private static function getMinValue(): float
    {
        return 55.8;
    }

    private static function getMaxValue(): float
    {
        return 1000.75;
    }

    private static function isValidValue(float|null $value): bool
    {
        return self::_isValidValue($value) && $value !== 777.25;
    }
}
