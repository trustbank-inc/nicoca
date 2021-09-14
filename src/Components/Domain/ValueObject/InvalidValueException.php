<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\ValueObject;

use RuntimeException;

/**
 * 値オブジェクト生成時のバリデーションエラー
 */
final class InvalidValueException extends RuntimeException
{
    public function __construct(?string $value, string $className)
    {
        parent::__construct("{$className}に適合しない値です。({$value})", 0, null);
    }
}
