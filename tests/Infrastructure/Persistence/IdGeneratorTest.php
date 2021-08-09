<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence;

use PHPUnit\Framework\TestCase;
use Seasalt\Nicoca\Components\Infrastructure\Persistence\IdGeneratorImpl;

final class IdGeneratorTest extends TestCase
{
    public function testCanBeCreatedUniqueId(): void
    {
        $idGenerator = new IdGeneratorImpl();

        $ids = [];
        for ($i = 0; $i < 100000; $i++) {
            $ids[] = $idGenerator->generate();
        }
        $this->assertSameSize($ids, array_unique($ids));
    }
}
