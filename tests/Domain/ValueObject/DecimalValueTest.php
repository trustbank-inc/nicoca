<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class DecimalValueTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $value = DecimalValueMock::fromString('123.45');
        $this->assertSame(123.45, $value->getValue());
    }

    public function testCanBeCreatedFromNumber(): void
    {
        $value = DecimalValueMock::fromNumber(256.67);
        $this->assertSame(256.67, $value->getValue());
    }

    public function testCanBeCreatedMinNumber(): void
    {
        $value = DecimalValueMock::fromNumber(55.8);
        $this->assertSame(55.8, $value->getValue());
    }

    public function testCannotBeValidatedMinNumber(): void
    {
        $this->expectException(InvalidValueException::class);
        DecimalValueMock::fromNumber(55.7);
    }

    public function testCanBeCreatedMaxNumber(): void
    {
        $value = DecimalValueMock::fromNumber(1000.75);
        $this->assertSame(1000.75, $value->getValue());
    }

    public function testCannotBeValidatedMaxNumber(): void
    {
        $this->expectException(InvalidValueException::class);
        DecimalValueMock::fromNumber(1000.76);
    }

    public function testCannotBeValidated(): void
    {
        $this->expectException(InvalidValueException::class);
        DecimalValueMock::fromString('abcde');
    }

    public function testCannotBeValidatedByCustomMethod(): void
    {
        $this->expectException(InvalidValueException::class);
        DecimalValueMock::fromNumber(777.25);
    }

    public function testCannotBeValidatedFromNumberOnNull(): void
    {
        $this->expectException(InvalidValueException::class);
        DecimalValueMock::fromNumber(null);
    }

    public function testCannotBeValidatedFromStringOnNull(): void
    {
        $this->expectException(InvalidValueException::class);
        DecimalValueMock::fromString(null);
    }

    public function testCanCompareValues(): void
    {
        $value = DecimalValueMock::fromNumber(123.45);
        $this->assertTrue($value->equals(123.45));

        $value2 = DecimalValueMock::fromNumber(555.123);
        $value3 = DecimalValueMock::fromNumber(123.45);
        $this->assertFalse($value->equals($value2));
        $this->assertTrue($value->equals($value3));
    }
}
