<?php
declare(strict_types=1);

namespace Tests\UseCase;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

final class ExampleQuantity
{
    use IntegerValue;

    /**
     * @param int $value
     * @return bool
     */
    public static function isValidValue(int $value): bool
    {
        return $value % 2 === 0;
    }
}
