<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Infrastructure\Persistence;

use Seasalt\Nicoca\Components\Domain\Persistence\Paginator;

trait PaginatorCreatable
{
    /**
     * @param array $records
     * @param int $total
     * @param int $limit
     * @param int $currentPage
     * @param int $lastPage
     * @return Paginator
     */
    public function createPaginator(
        array $records,
        int $total,
        int $limit,
        int $currentPage,
        int $lastPage): Paginator
    {
        return new class($records, $total, $limit, $currentPage, $lastPage) implements Paginator
        {
            public function __construct(
                private array $records,
                private int $total,
                private int $limit,
                private int $currentPage,
                private int $lastPage) {}
            public function getRecords(): array { return $this->records; }
            public function getTotal(): int { return $this->total; }
            public function getLimit(): int { return $this->limit; }
            public function getCurrentPage(): int { return $this->currentPage; }
            public function getLastPage(): int { return $this->lastPage; }
        };
    }
}
