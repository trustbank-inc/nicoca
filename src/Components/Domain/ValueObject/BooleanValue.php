<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\ValueObject;

/**
 * 真偽値オブジェクトの性質を提供する
 */
trait BooleanValue
{
    /**
     * new禁止
     *
     * @param bool $value
     * @see fromString()
     */
    private function __construct(private bool $value)
    {

    }

    /**
     * プリミティブ型で値を取得する
     *
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * インスタンス生成元として有効な文字列かどうか確認する
     *
     * @param string|null $value
     * @return bool
     */
    public static function isValidString(string|null $value): bool
    {
        if ($value === null) {
            return false;
        }
        return in_array(
            needle: strtolower($value),
            haystack: array_merge(self::getTrueValues(), self::getFalseValues()));
    }

    /**
     * 文字列からオブジェクトを生成する
     *
     * @param string|null $value
     * @return static
     */
    public static function fromString(string|null $value): static
    {
        if (!self::isValidString($value)) {
            throw new InvalidValueException($value, static::class);
        }
        return new self(in_array(
            needle: strtolower($value),
            haystack: self::getTrueValues()));
    }

    /**
     * @return string[]
     * @note 比較の簡略化のため小文字のみで定義する
     */
    protected static function getTrueValues(): array
    {
        return ['1', 'true', 'on'];
    }

    /**
     * @return string[]
     * @note 比較の簡略化のため小文字のみで定義する
     */
    protected static function getFalseValues(): array
    {
        return ['0', 'false', 'off'];
    }
}
