<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\UseCase;

use Seasalt\Nicoca\Components\Domain\ValueObject\IntegerValue;

/**
 * 1ページあたりの件数
 */
final class LimitPerPage
{
    use IntegerValue {
        fromString as private _fromString;
    }

    public static function getMinValue(): int
    {
        return 1;
    }

    public static function getMaxValue(): int
    {
        return 1000;
    }

    /**
     * 文字列からオブジェクトを生成する
     *
     * @param string $value
     * @return self
     */
    public static function fromString(string $value): self
    {
        if ($value === '') {
            return self::fromNumber(self::getMaxValue());
        }
        return self::_fromString($value);
    }
}
