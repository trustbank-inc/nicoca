<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class IntegerValueTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $value = IntegerValueMock::fromString('123');
        $this->assertSame(123, $value->getValue());
    }

    public function testCanBeCreatedFromNumber(): void
    {
        $value = IntegerValueMock::fromNumber(777);
        $this->assertSame(777, $value->getValue());
    }

    public function testCanBeCreatedMinNumber(): void
    {
        $value = IntegerValueMock::fromNumber(100);
        $this->assertSame(100, $value->getValue());
    }

    public function testCannotBeValidatedMinNumber(): void
    {
        $this->expectException(InvalidValueException::class);
        IntegerValueMock::fromNumber(99);
    }

    public function testCanBeCreatedMaxNumber(): void
    {
        $value = IntegerValueMock::fromNumber(9999);
        $this->assertSame(9999, $value->getValue());
    }

    public function testCannotBeValidatedMaxNumber(): void
    {
        $this->expectException(InvalidValueException::class);
        IntegerValueMock::fromNumber(10000);
    }

    public function testCannotBeValidated(): void
    {
        $this->expectException(InvalidValueException::class);
        IntegerValueMock::fromString('abcde');
    }

    public function testCannotBeValidatedByCustomMethod(): void
    {
        $this->expectException(InvalidValueException::class);
        IntegerValueMock::fromNumber(7);
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
}
