<?php
declare(strict_types=1);

namespace Seasalt\Nicoca;

use Illuminate\Support\ServiceProvider;
use Seasalt\Nicoca\Components\Domain\Persistence\IdGenerator;
use Seasalt\Nicoca\Components\Infrastructure\Persistence\IdGeneratorImpl;

/**
 * 各コンポーネントのサービスを登録する
 */
final class ComponentServiceProvider extends ServiceProvider
{
    /**
     * コマンドにより生成されたサービスをロードする
     */
    public function register(): void
    {
        $this->app->bind(IdGenerator::class, IdGeneratorImpl::class);
    }
}
