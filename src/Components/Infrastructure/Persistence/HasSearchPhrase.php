<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Seasalt\Nicoca\Components\UseCase\SearchPhrase;

trait HasSearchPhrase
{
    /**
     * 検索フレーズに応じたwhere句を組み立てる
     *
     * @param EloquentBuilder|QueryBuilder $builder クエリビルダ
     * @param SearchPhrase|null $searchPhrase 検索フレーズ
     * @param array $fields 検索対象とするフィールド名
     */
    private function buildSearchPhraseWhereClauses(
        EloquentBuilder|QueryBuilder $builder,
        SearchPhrase|null $searchPhrase,
        array $fields): void
    {
        if (!$searchPhrase?->hasValue()) {
            return;
        }
        if ($searchPhrase->isPartialMatch()) {
            $value = "%{$searchPhrase}%";
            $operator = 'LIKE';
        } elseif ($searchPhrase->isPrefixMatch()) {
            $value = "{$searchPhrase}%";
            $operator = 'LIKE';
        } elseif ($searchPhrase->isSuffixMatch()) {
            $value = "%{$searchPhrase}";
            $operator = 'LIKE';
        } elseif ($searchPhrase->isExactMatch()) {
            $value = $searchPhrase->getValue();
            $operator = '=';
        }
        $builder->where(function (EloquentBuilder|QueryBuilder $builder) use ($fields, $value, $operator) {
            foreach ($fields as $field) {
                if (str_contains($field, '.')) {
                    $relations = substr($field, 0, strrpos($field, '.'));
                    $field = substr($field, strrpos($field, '.') + 1);
                    $builder->orWhereHas($relations, function (EloquentBuilder $builder) use ($field, $value, $operator) {
                        $builder->where($field, $operator, $value);
                    });
                } else {
                    $builder->orWhere($field, $operator, $value);
                }
            }
        });
    }
}
