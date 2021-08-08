<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Domain\Persistence;

/**
 * エンティティで使用するIDの生成
 */
interface IdGenerator
{
    public function generate(): string;
}
