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
     * @param SearchPhrase $searchPhrase 検索フレーズ
     * @param array $fields 検索対象とするフィールド名
     */
    private function buildSearchPhraseWhereClauses(EloquentBuilder|QueryBuilder $builder, SearchPhrase $searchPhrase, array $fields): void
    {
        if (!$searchPhrase->hasValue()) {
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
                $builder->orWhere($field, $operator, $value);
            }
        });
    }
}
