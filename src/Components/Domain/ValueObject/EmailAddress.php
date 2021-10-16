<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\ValueObject;

/**
 * メールアドレス
 */
class EmailAddress
{
    use StringValue;

    /**
     * 文字数の下限値
     *
     * @return int
     */
    private static function getMinLength(): int
    {
        return 6;
    }

    /**
     * 文字数の上限値
     *
     * @return int
     */
    private static function getMaxLength(): int
    {
        return 256;
    }

    /**
     * 有効な値か確認する
     *
     * 実装クラスでの制限用
     *
     * @param string|null $value
     * @return bool
     */
    public static function isValidValue(string|null $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
