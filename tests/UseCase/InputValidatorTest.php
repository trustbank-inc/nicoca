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
}
