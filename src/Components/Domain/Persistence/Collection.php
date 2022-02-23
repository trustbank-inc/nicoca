<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\Persistence;

use IteratorAggregate;

/**
 * ドメインオブジェクトのコレクションインターフェース
 */
interface Collection extends IteratorAggregate
{
    /**
     * 総件数
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * 1ページ当たりの表示件数
     *
     * @return int
     */
    public function getLimit(): int;

    /**
     * 現在ページ
     *
     * @return int
     */
    public function getCurrentPage(): int;

    /**
     * 最終ページ
     *
     * @return int
     */
    public function getLastPage(): int;

    /**
     * 次ページがあるかどうか
     *
     * @return bool
     */
    public function hasMorePages(): bool;
}
