<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\UseCase;

use InvalidArgumentException;

/**
 * ユースケースの入力値のバリデーションエラー
 */
final class InvalidInputException extends InvalidArgumentException
{
    public function __construct(array $errors, array $input)
    {
        $errorFields = implode(', ', $errors);
        $message = "ユースケースで不正な入力値を検出しました。";
        $message .= "\n不正なフィールド：{$errorFields}";
        $message .= "\n入力値：\n" . print_r($input, true);
        parent::__construct($message, 0, null);
    }
}
