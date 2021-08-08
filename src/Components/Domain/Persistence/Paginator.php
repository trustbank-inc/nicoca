<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\Persistence;

/**
 * リポジトリでリストを復元する際のインターフェース
 */
interface Paginator
{
    /**
     * 現在ページ分のレコード
     *
     * @return array
     */
    public function getRecords(): array;

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
}
