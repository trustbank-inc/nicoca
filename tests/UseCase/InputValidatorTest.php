<?php
declare(strict_types=1);

namespace Tests\UseCase;

use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\UseCase\InputValidator;
use Seasalt\Nicoca\Components\UseCase\InvalidInputException;

final class InputValidatorTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeValidatedStringValue(): void
    {
        $validator = new InputValidator(
            requiredFields: [
                'title' => ExampleTitle::class,
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'title' => 'abcdefg'
        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedTooShort(): void
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [
                'title' => ExampleTitle::class,
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'title' => 'a'
        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedTooLong(): void
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [
                'title' => ExampleTitle::class,
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'title' => 'abcdefghijklmn'
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeValidatedNestedValue(): void
    {
        $validator = new InputValidator(
            requiredFields: [
                'title' => ExampleTitle::class,
                'detail' => [
                    'quantity' => ExampleQuantity::class,
                ],
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'title' => 'abcdefg',
            'detail' => [
                [
                    'quantity' => '100',
                ],
                [
                    'quantity' => '200',
                ],
                [
                    'quantity' => '300',
                ],
            ],
        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedNestedValue(): void
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [
                'title' => ExampleTitle::class,
                'detail' => [
                    'quantity' => ExampleQuantity::class,
                ],
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'title' => 'abcdefg',
            'detail' => [
                [
                    'quantity' => '3',
                ],
                [
                    'quantity' => '4',
                ],
                [
                    'quantity' => '5',
                ],
            ],
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeOmittedOptionalValue(): void
    {
        $validator = new InputValidator(
            requiredFields: [

            ],
            optionalFields: [
                'optional_title' => ExampleTitle::class,
                'detail' => [
                    'quantity' => ExampleQuantity::class,
                ],
            ]);
        $validator->validate([

        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedInvalidOptionalValue(): void
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [

            ],
            optionalFields: [
                'optional_title' => ExampleTitle::class,
                'detail' => [
                    'quantity' => ExampleQuantity::class,
                ],
            ]);
        $validator->validate([
            'optional_title' => 'a',
            'detail' => [
                [
                    'quantity' => '5',
                ],
            ],
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeValidatedOnStringArrayValue(): void
    {
        $validator = new InputValidator(
            requiredFields: [
                'quantity' => ExampleQuantity::class,
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'quantity' => ['2', '4', '6',],
        ]);
    }

    /**
     * @test
     */
    public function testCanBeExceptedOnStringArrayValue(): void
    {
        $this->expectException(InvalidInputException::class);
        $validator = new InputValidator(
            requiredFields: [
                'quantity' => ExampleQuantity::class,
            ],
            optionalFields: [

            ]);
        $validator->validate([
            'quantity' => ['abcde', 'efghi', 'jklmn',],
        ]);
    }

    /**
     * @test
     */
    public function testCanValidatedBeFetched(): void
    {
        $validator = new InputValidator(
            requiredFields: [
            ],
            optionalFields: [
                'title' => ExampleTitle::class,
                'array_title' => ExampleTitle::class,
                'null_title' => ExampleTitle::class,
                'detail' => [
                    'quantity' => ExampleQuantity::class,
                    'description' => ExampleTitle::class,
                ],
            ]);
        $validator->validate([
                'title' => 'abcdef',
                'array_title' => ['abcde', 'fghij', 'klmno',],
                'detail' => [
                    [
                        'quantity' => '2',
                    ],
                    [
                        'quantity' => '4',
                    ],
                    [
                        'quantity' => '6',
                    ],
                ],
            ],);
        $this->assertEquals(ExampleTitle::fromString('abcdef'), $validator->getValidated('title'));
        $this->assertEquals([
                ExampleTitle::fromString('abcde'),
                ExampleTitle::fromString('fghij'),
                ExampleTitle::fromString('klmno'),
            ], $validator->getValidated('array_title'));
        $this->assertEquals(null, $validator->getValidated('null_title'));
        $this->assertEquals([
                [
                    'quantity' => ExampleQuantity::fromString('2'),
                    'description' => null,
                ],
                [
                    'quantity' => ExampleQuantity::fromString('4'),
                    'description' => null,
                ],
                [
                    'quantity' => ExampleQuantity::fromString('6'),
                    'description' => null,
                ],
            ], $validator->getValidated('detail'));
        $this->assertEquals([
                'title' => ExampleTitle::fromString('abcdef'),
                'array_title' => [
                    ExampleTitle::fromString('abcde'),
                    ExampleTitle::fromString('fghij'),
                    ExampleTitle::fromString('klmno'),
                ],
                'null_title' => null,
                'detail' => [
                    [
                        'quantity' => ExampleQuantity::fromString('2'),
                        'description' => null,
                    ],
                    [
                        'quantity' => ExampleQuantity::fromString('4'),
                        'description' => null,
                    ],
                    [
                        'quantity' => ExampleQuantity::fromString('6'),
                        'description' => null,
                    ],
                ]
            ], $validator->getValidated());
    }

    /**
     *
     */
    public function testCanBeExceptedRequiredValueMissing()
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [
                'title' => ExampleTitle::class,
            ]);
        $validator->validate([]);
    }

    /**
     *
     */
    public function testCanBeExceptedInvalidArrayValue()
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [
                'records' => [
                    'title' => ExampleTitle::class,
                ],
            ]);
        $validator->validate([
            'records' => 'test',
        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedInvalidNestedArrayValue()
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputValidator(
            requiredFields: [
                'records' => [
                    'title' => ExampleTitle::class,
                ],
            ]);
        $validator->validate([
            'records' => [
                'test',
            ],
        ]);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCanBeValidatedNonArrayNestedValue(): void
    {
        $validator = new InputValidator(
            requiredFields: [
                'book.title' => ExampleTitle::class,
            ]);
        $validator->validate([
            'book' => [
                'title' => 'abcdefg',
            ],
        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedNonArrayNestedValue(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('book.title is invalid');

        $validator = new InputValidator(
            requiredFields: [
                'book.title' => ExampleTitle::class,
            ]);
        $validator->validate([
            'book' => [
                'title' => 'abcdefgaaaaaaaaaaaaaaaaaaaaa',
            ],
        ]);
    }

    /**
     *
     */
    public function testCanBeExceptedNonArrayNestedValueRequired(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('book.title is required');

        $validator = new InputValidator(
            requiredFields: [
                'book.title' => ExampleTitle::class,
            ]);
        $validator->validate([
            'book' => [

            ],
        ]);
    }

    /**
     * 空の配列をvalidatedで取得できること
     */
    public function testCanGetValidatedEmptyArray(): void
    {
        $validator = new InputValidator(
            requiredFields: [
                'titles' => ExampleTitle::class,
            ]);
        $validator->validate([
            'titles' => [],
        ]);
        $this->assertSame(
            expected: [],
            actual: $validator->getValidated('titles')
        );
    }
}
