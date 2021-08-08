<?php
declare(strict_types=1);

namespace Seasalt\Nicoca\Components\Infrastructure\Persistence;

use Seasalt\Nicoca\Components\Domain\Persistence\IdGenerator;
use Ulid\Ulid;

/**
 * 生成順序が保持されるUUID
 */
final class IdGeneratorImpl implements IdGenerator
{
    public function generate(): string
    {
        return (string)Ulid::generate();
    }
}
