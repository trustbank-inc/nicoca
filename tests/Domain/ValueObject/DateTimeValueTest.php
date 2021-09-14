<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class DateTimeValueTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $value = DateTimeValueMock::fromString('2021-08-09T13:30:00+09:00');
        $this->assertEquals(new DateTimeImmutable('2021-08-09T13:30:00+09:00'), $value->getValue());
    }

    public function testCannotBeValidatedByCustomMethod(): void
    {
        $this->expectException(InvalidValueException::class);
        DateTimeValueMock::fromString('2021-04-01T12:00:00+09:00');
    }

    public function testCannotBeValidatedFromStringOnNull(): void
    {
        $this->expectException(InvalidValueException::class);
        DateTimeValueMock::fromString(null);
    }

    public function testCannotBeValidatedFromDateTimeOnNull(): void
    {
        $this->expectException(InvalidValueException::class);
        DateTimeValueMock::fromDateTime(null);
    }
}
