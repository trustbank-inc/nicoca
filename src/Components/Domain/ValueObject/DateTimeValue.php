<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\ValueObject;

use DateTimeImmutable;

/**
 * 日時の値オブジェクトの性質を提供する
 */
trait DateTimeValue
{
	/**
	 * new不可
	 *
	 * @param DateTimeImmutable $value
	 * @see fromString()
	 * @see fromDateTime()
	 * @see now()
	 */
	private final function __construct(private DateTimeImmutable $value)
	{

	}

	/**
	 * プリミティブ型で値を取得する
	 *
	 * @return DateTimeImmutable
	 */
	public final function getValue(): DateTimeImmutable
	{
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->value->format(static::getFormat());
	}

	/**
	 * 有効な文字列かどうか確認する
	 *
	 * @param string|null $value
	 * @return bool
	 */
	public static final function isValidString(?string $value): bool
	{
		if (is_null($value)) return false;
		if (DateTimeImmutable::createFromFormat(format: static::getFormat(), datetime: $value) === false) {
			return false;
		}
		return static::isValidValue(DateTimeImmutable::createFromFormat(format: static::getFormat(), datetime: $value));
	}

	/**
	 * 有効な値かどうか確認する
	 *
	 * @param DateTimeImmutable|null $value
	 * @return bool
	 */
	public static function isValidValue(?DateTimeImmutable $value): bool
	{
		if (is_null($value)) return false;
		return true;
	}

	/**
	 * 現在時刻のオブジェクトを生成する
	 *
	 * @return static
	 */
	public static final function now(): static
	{
		return new static(new DateTimeImmutable());
	}

    /**
     * 文字列からオブジェクトを生成する
     *
     * @param string|null $value
     * @return static
     */
	public static final function fromString(?string $value): static
	{
		if (!static::isValidString($value)) {
			throw new InvalidValueException($value, static::class);
		}
		return new static(DateTimeImmutable::createFromFormat(format: static::getFormat(), datetime: $value));
	}

	/**
	 * @param DateTimeImmutable|null $value
	 * @return static
	 */
	public static final function fromDateTime(?DateTimeImmutable $value): static
	{
		if (!static::isValidValue($value)) {
			throw new InvalidValueException($value->format(static::getFormat()), static::class);
		}
		return new static($value);
	}

	/**
	 * 文字列との変換で使用される日付フォーマット
	 *
	 * @return string
	 */
	private static function getFormat(): string
	{
		return 'Y-m-d\TH:i:sP';
	}
}
