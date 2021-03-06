<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class BooleanValueTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $value = BooleanValueMock::fromString('1');
        $this->assertTrue($value->getValue());

        $value = BooleanValueMock::fromString('True');
        $this->assertTrue($value->getValue());

        $value = BooleanValueMock::fromString('ON');
        $this->assertTrue($value->getValue());

        $value = BooleanValueMock::fromString('0');
        $this->assertFalse($value->getValue());

        $value = BooleanValueMock::fromString('false');
        $this->assertFalse($value->getValue());

        $value = BooleanValueMock::fromString('ofF');
        $this->assertFalse($value->getValue());
    }

    public function testCannotBeValidated(): void
    {
        $this->expectException(InvalidValueException::class);
        BooleanValueMock::fromString('100');
    }

    public function testCannotBeValidatedOnNull(): void
    {
        $this->expectException(InvalidValueException::class);
        BooleanValueMock::fromString(null);
    }

    public function testCanBeCreatedFromBoolean(): void
    {
        $value = BooleanValueMock::fromBoolean(true);
        $this->assertTrue($value->getValue());
        $value = BooleanValueMock::fromBoolean(false);
        $this->assertFalse($value->getValue());
    }

    public function testCanBeExceptedFromBooleanOnNull(): void
    {
        $this->expectException(InvalidValueException::class);
        BooleanValueMock::fromBoolean(null);
    }

    public function testCanCompareValues(): void
    {
        $value = BooleanValueMock::fromBoolean(true);
        $this->assertTrue($value->equals(true));

        $value2 = BooleanValueMock::fromBoolean(false);
        $value3 = BooleanValueMock::fromBoolean(true);
        $this->assertFalse($value->equals($value2));
        $this->assertTrue($value->equals($value3));
    }
}
