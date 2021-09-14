<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use DateTimeImmutable;
use Seasalt\Nicoca\Components\Domain\ValueObject\DateTimeValue;

final class DateTimeValueMock
{
    use DateTimeValue {
        isValidValue as private _isValidValue;
    }

    private static function isValidValue(?DateTimeImmutable $value): bool
    {
        return self::_isValidValue($value) && $value->getTimestamp() !== strtotime('2021-04-01T12:00+09:00');
    }
}
