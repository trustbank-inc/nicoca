<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\UseCase;

/**
 * 検索フレーズ
 */
final class SearchPhrase
{
    /** @var int 部分一致 */
    private const PARTIAL = 1;
    /** @var int 前方一致 */
    private const PREFIX = 2;
    /** @var int 後方一致 */
    private const SUFFIX = 3;
    /** @var int 完全一致 */
    private const EXACT = 4;
    /** @var string 両端を示すマーク */
    private const TERMINATE_MARK = '|';

    private function __construct(private string $value, private int $matchType)
    {

    }

    /**
     * @return bool
     */
    public function hasValue(): bool
    {
        return $this->value !== '';
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * 部分一致かどうか
     *
     * @return bool
     */
    public function isPartialMatch(): bool
    {
        return $this->matchType === self::PARTIAL;
    }

    /**
     * 前方一致かどうか
     *
     * @return bool
     */
    public function isPrefixMatch(): bool
    {
        return $this->matchType === self::PREFIX;
    }

    /**
     * 後方一致かどうか
     *
     * @return bool
     */
    public function isSuffixMatch(): bool
    {
        return $this->matchType === self::SUFFIX;
    }

    /**
     * 完全一致かどうか
     *
     * @return bool
     */
    public function isExactMatch(): bool
    {
        return $this->matchType === self::EXACT;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return self
     */
    public static function fromString(string $value): self
    {
        // 一致方法の判定
        if (self::startWith($value) && self::endWith($value)) {
            $matchType = self::EXACT;
            $value = mb_substr(string: $value, start: 1);
            $value = mb_substr(string: $value, start: 0, length: mb_strlen($value) - 1);
        } elseif (self::startWith($value)) {
            $matchType = self::PREFIX;
            $value = mb_substr(string: $value, start: 1);
        } elseif (self::endWith($value)) {
            $matchType = self::SUFFIX;
            $value = mb_substr(string: $value, start: 0, length: mb_strlen($value) - 1);
        } else {
            $matchType = self::PARTIAL;
        }
        return new self(value: $value, matchType: $matchType);
    }

    /**
     *  開始マークが付いているかどうか
     *
     * @param string $value
     * @return bool
     */
    private static function startWith(string $value): bool
    {
        return mb_substr(string: $value, start: 0, length: 1) === self::TERMINATE_MARK;
    }

    /**
     * 終端マークが付いているかどうか
     *
     * @param string $value
     * @return bool
     */
    private static function endWith(string $value): bool
    {
        return mb_substr(string: $value, start: -1, length: 1) === self::TERMINATE_MARK;
    }

    /**
     * 有効な値か確認する
     *
     * InputValidatorとの互換性のために用意
     *
     * @param string $value
     * @return bool
     * @noinspection PhpUnusedParameterInspection
     */
    public static function isValidString(string $value): bool
    {
        return true;
    }
}
