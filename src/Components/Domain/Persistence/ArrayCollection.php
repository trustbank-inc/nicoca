<?php

declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\Persistence;

use ArrayIterator;
use Traversable;

final class ArrayCollection implements Collection
{
    public function __construct(protected array $elements)
    {

    }

    public function getTotal(): int
    {
        return count($this->elements);
    }

    public function getLimit(): int
    {
        return $this->getTotal();
    }

    public function getCurrentPage(): int
    {
        return 1;
    }

    public function getLastPage(): int
    {
        return 1;
    }

    public function hasMorePages(): bool
    {
        return false;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }
}