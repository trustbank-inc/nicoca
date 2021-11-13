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

    /** @var array validateが通過し、各フィールドをインスタンス化したものを含んだ配列 */
    private array $validated = [];

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
     * @param string[]|string[][]|string[][][] $input 文字列の入力値（GET/POSTを想定）
     */
    public function validate(array $input): void
    {
        $this->errors = [];
        $this->validateFields(input: $input, fields: $this->requiredFields, required: true);
        $this->validateFields(input: $input, fields: $this->optionalFields, required: false);
        if (count($this->errors) > 0) {
            throw new InvalidInputException(errors: $this->errors, input: $input);
        }
        $this->setValidated($input);
    }

    /**
     * ユースケースの入力値を検証する
     *
     * @param string[]|string[][]|string[][][] $input 文字列で指定される配列（POST値を想定）
     * @param array $fields フィールド名+型
     * @param bool $required 必須パラメータかどうか
     * @note $fieldsの各フィールド型はisValidString()を実装している必要がある。
     * @see StringValue
     */
    private function validateFields(array $input, array $fields, bool $required): void
    {
        foreach ($fields as $fieldName => $className) {
            if (!$this->inputValueExists($input, $fieldName, $className)) {
                if ($required) {
                    $this->errors[] = "$fieldName is required";
                }
                continue;
            }

            if (is_array($className)) {
                if (!is_array($input[$fieldName])) {
                    $this->errors[] = "$fieldName is not array";
                } else {
                    foreach ($input[$fieldName] as $key => $child) {
                        if (!is_array($child)) {
                            if (!isset($className[$key])) {
                                $this->errors[] = "$fieldName.$key is invalid";
                                continue;
                            }
                            $childClassName = $className[$key];
                            if (!$childClassName::isValidString((string)$child)) {
                                $this->errors[] = "$fieldName.$key is invalid";
                            }
                            continue;
                        }
                        $this->validateFields(input: $child, fields: $className, required: $required);
                    }
                }
                continue;
            }

            if (str_contains(haystack: $fieldName, needle: '.')) {
                $nestedInputValue = $input;
                foreach (explode(separator: '.', string: $fieldName) as $fieldPart) {
                    $nestedInputValue = $nestedInputValue[$fieldPart];
                }
                if (!$className::isValidString((string)$nestedInputValue)) {
                    $this->errors[] = "$fieldName is invalid";
                }
            } else {
                if (is_array($input[$fieldName])) {
                    foreach ($input[$fieldName] as $index => $inputValue) {
                        if (!$className::isValidString((string)$inputValue)) {
                            $this->errors[] = "$fieldName.$index is invalid";
                        }
                    }
                } else {
                    if (!$className::isValidString((string)$input[$fieldName])) {
                        $this->errors[] = "$fieldName is invalid";
                    }
                }
            }
        }
    }

    /**
     * @param array $input
     * @param string $fieldName
     * @param string|array $field
     * @return bool
     */
    private function inputValueExists(array $input, string $fieldName, string|array $field): bool
    {
        if (!is_array($field)) {
            if (str_contains(haystack: $fieldName, needle: '.')) {
                $nestedInputValue = $input;
                foreach (explode(separator: '.', string: $fieldName) as $fieldPart) {
                    if (!isset($nestedInputValue[$fieldPart])) {
                        return false;
                    }
                    $nestedInputValue = $nestedInputValue[$fieldPart];
                }
                return $nestedInputValue !== '';
            } else {
                return isset($input[$fieldName]) && $input[$fieldName] !== '';
            }
        }

        if (!isset($input[$fieldName]) || !is_array($input[$fieldName])) {
            return false;
        }

        foreach ($field as $childFieldName => $childFieldClassName) {
            if (!isset($input[$fieldName])) {
                return false;
            }
            if (!is_array($input[$fieldName])) {
                return false;
            }
            foreach ($input[$fieldName] as $childInput) {
                if (!isset($childInput[$childFieldName]) || $childInput[$childFieldName] === '') {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * $validatedのGetter
     * 
     * @param string|null $fieldName
     * @return mixed
     */
    public function getValidated(string|null $fieldName = null): mixed
    {
        if (isset($fieldName)) {
            return $this->validated[$fieldName];
        }
        return $this->validated;
    }

    /**
     * $validatedのSetter
     * 
     * @param string[]|string[][]|string[][][] $input
     * @return void
     */
    private function setValidated(array $input): void
    {
        $fields = array_merge($this->requiredFields, $this->optionalFields);
        foreach ($fields as $fieldName => $className) {
            if (!isset($input[$fieldName])) {
                $this->validated[$fieldName] = null;
                continue;
            }
            if (is_array($className)) {
                foreach ($input[$fieldName] as $index => $childInput) {
                    foreach ($className as $childFieldName => $childClassName) {
                        if (!isset($childInput[$childFieldName])) {
                            $this->validated[$fieldName][$index][$childFieldName] = null;
                            continue;
                        }
                        $this->validated[$fieldName][$index][$childFieldName] = $childClassName::fromString((string)$childInput[$childFieldName]);
                    }
                } 
            } else {
                if (is_array($input[$fieldName])) {
                    $this->validated[$fieldName] = [];
                    foreach ($input[$fieldName] as $value) {
                        $this->validated[$fieldName][] = $className::fromString((string)$value);
                    }
                } else {
                    $this->validated[$fieldName] = $className::fromString((string)$input[$fieldName]);
                }
            }
        }
    }
}
