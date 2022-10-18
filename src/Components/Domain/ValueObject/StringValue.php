<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\ValueObject;

/**
 * 文字列の値オブジェクトの性質を提供する
 */
trait StringValue
{
    /**
     * new禁止
     *
     * @param string $value
     * @see fromString()
     */
    private function __construct(private string $value)
    {

    }

    /**
     * プリミティブ型で値を取得する
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string|StringValue $value
     * @return bool
     */
    public function equals(self|string $value): bool
    {
        if ($value instanceof self) {
            return $value->value === $this->value;
        } else {
            return $value === $this->value;
        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }

    /**
     * 文字数の下限値
     *
     * @return int
     */
    private static function getMinLength(): int
    {
        return 0;
    }

    /**
     * 文字数の上限値
     *
     * @return int
     */
    private static function getMaxLength(): int
    {
        return 4194303;
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
            $value = '';
        }
        $min = static::getMinLength();
        if (mb_strlen($value, 'UTF-8') < $min) {
            return false;
        }
        $max = static::getMaxLength();
        if (mb_strlen($value, 'UTF-8') > $max) {
            return false;
        }
        return static::isValidValue($value);
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
        return true;
    }

    /**
     * 文字列からオブジェクトを生成する
     *
     * @param string|null $value
     * @return static
     */
    public static function fromString(string|null $value): static
    {
        if ($value === null) {
            $value = '';
        }
        if (!static::isValidString($value)) {
            throw new InvalidValueException($value, static::class);
        }
        return new static($value);
    }
}
