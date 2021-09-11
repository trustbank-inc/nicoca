<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\UseCase;

use Seasalt\Nicoca\Components\Domain\ValueObject\StringValue;

/**
 * ユースケース用の入力バリデータ
 */
final class InputValidator
{
    /** @var array エラーがあったフィールド */
    private array $errors = [];

    /**
     * @param array $requiredFields 必須項目
     * @param array $optionalFields 省略可能項目
     * @note 各フィールドは[フィールド名 => クラス名]で指定する。
     */
    public function __construct(
        private array $requiredFields,
        private array $optionalFields = [])
    {

    }

    /**
     * ユースケースの入力値を検証する
     *
     * @param string[] $input 文字列の入力値（GET/POSTを想定）
     */
    public function validate(array $input): void
    {
        $this->errors = [];
        $this->validateFields(input: $input, fields: $this->requiredFields, required: true);
        $this->validateFields(input: $input, fields: $this->optionalFields, required: false);
        if (count($this->errors) > 0) {
            throw new InvalidInputException(errors: $this->errors, input: $input);
        }
    }

    /**
     * ユースケースの入力値を検証する
     *
     * @param array<string, (string|string[])> $input 文字列で指定される配列（POST値を想定）
     * @param array<string, string> $fields フィールド名+型
     * @param bool $required 必須パラメータかどうか
     * @note $fieldsの各フィールド型はisValidString()を実装している必要がある。
     * @see StringValue
     */
    private function validateFields(array $input, array $fields, bool $required): void
    {
        foreach ($fields as $fieldName => $className) {
            if (!isset($input[$fieldName]) || $input[$fieldName] === '' || $input[$fieldName] === []) {
                if ($required) {
                    $this->errors[] = "{$fieldName} is required";
                }
                continue;
            }
            if (is_array($className)) {
                if (!is_array($input[$fieldName])) {
                    $this->errors[] = "{$fieldName} is not array";
                    continue;
                }
                $this->validateFields(input: $input[$fieldName], fields: $className, required: $required);
                continue;
            }

            if (is_array($input[$fieldName])) {
                foreach ($input[$fieldName] as $index => $inputValue) {
                    if (!$className::isValidString((string)$inputValue)) {
                        $this->errors[] = "{$fieldName}.{$index} is invalid";
                    }
                }
            } else {
                if (!$className::isValidString((string)$input[$fieldName])) {
                    $this->errors[] = "{$fieldName} is invalid";
                }
            }
        }
    }
}
