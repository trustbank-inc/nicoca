<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\ValueObject;

/**
 * 数値の値オブジェクトの性質を提供する
 */
trait IntegerValue
{
    /**
     * new禁止
     *
     * @param int $value
     * @see fromString()
     */
    private function __construct(private int $value)
    {

    }

    /**
     * プリミティブ型で値を取得する
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * 最小値を取得する
     *
     * @return int
     */
    private static function getMinValue(): int
    {
        return PHP_INT_MIN;
    }

    /**
     * 最大値を取得する
     *
     * @return int
     */
    private static function getMaxValue(): int
    {
        return PHP_INT_MAX;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getValue();
    }

    /**
     * 有効な値かどうか検証する
     *
     * @param int $value
     * @return bool
     */
    public static function isValidValue(int $value): bool
    {
        return $value >= static::getMinValue() && $value <= static::getMaxValue();
    }

    /**
     * インスタンス生成元として有効な文字列かどうか確認する
     *
     * @param string $value
     * @return bool
     */
    public static function isValidString(string $value): bool
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false &&
            filter_var($value, FILTER_VALIDATE_FLOAT) === false) {
            return false;
        }
        return self::isValidValue(intval($value));
    }

    /**
     * 数値からオブジェクトを生成する
     *
     * @param int $value
     * @return static
     */
    public static function fromNumber(int $value): static
    {
        if (!static::isValidValue($value)) {
            throw new InvalidValueException((string)$value, static::class);
        }
        return new static($value);
    }

    /**
     * 文字列からオブジェクトを生成する
     *
     * @param string $value
     * @return static
     */
    public static function fromString(string $value): static
    {
        if (!self::isValidString($value)) {
            throw new InvalidValueException($value, static::class);
        }
        return self::fromNumber(intval($value));
    }
}
