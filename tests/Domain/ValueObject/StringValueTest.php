<?php
declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\Domain\ValueObject\InvalidValueException;

final class StringValueTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $value = StringValueMock::fromString('TestString!');
        $this->assertSame('TestString!', $value->getValue());
        $value = StringValueMockForNullTest::fromString(null);
        $this->assertSame('', $value->getValue());
    }

    public function testCanBeCreatedMinLengthString(): void
    {
        $value = StringValueMock::fromString('abc');
        $this->assertSame('abc', $value->getValue());
    }

    public function testCannotBeValidatedMinLength(): void
    {
        $this->expectException(InvalidValueException::class);
        StringValueMock::fromString('ab');
    }

    public function testCanBeCreatedMaxLengthString(): void
    {
        $value = StringValueMock::fromString('abcde12345ABCDE67890');
        $this->assertSame('abcde12345ABCDE67890', $value->getValue());
    }

    public function testCannotBeValidatedMaxLength(): void
    {
        $this->expectException(InvalidValueException::class);
        StringValueMock::fromString('abcde12345ABCDE67890-');
    }

    public function testCannotBeValidatedByCustomMethod(): void
    {
        $this->expectException(InvalidValueException::class);
        StringValueMock::fromString('abc**INVALID**');
    }

    public function testCanCompareValues(): void
    {
        $value = StringValueMock::fromString('abc');
        $this->assertTrue($value->equals('abc'));

        $value2 = StringValueMock::fromString('def');
        $value3 = StringValueMock::fromString('abc');
        $this->assertFalse($value->equals($value2));
        $this->assertTrue($value->equals($value3));
    }
}
