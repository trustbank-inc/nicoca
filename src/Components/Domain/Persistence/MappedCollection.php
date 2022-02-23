<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\Persistence;

use Traversable;

/**
 * コレクションの中身にコールバック関数を適用する
 */
final class MappedCollection implements Collection
{
    public function __construct(private Collection $base, private $callback)
    {

    }

    public function getTotal(): int
    {
        return $this->base->getTotal();
    }

    public function getLimit(): int
    {
        return $this->base->getLimit();
    }

    public function getCurrentPage(): int
    {
        return $this->base->getCurrentPage();
    }

    public function getLastPage(): int
    {
        return $this->base->getLastPage();
    }

    public function hasMorePages(): bool
    {
        return $this->base->hasMorePages();
    }

    public function getIterator(): Traversable
    {
        foreach ($this->base as $element) {
            yield call_user_func($this->callback, $element);
        }
    }
}
