<?php

namespace App\Actions\v1\Metrics;

use App\Infra\Interfaces\UseCaseInterface;
use App\Models\MetricHistoryRun;

class SaveMetrics implements UseCaseInterface
{
    public function __construct(
        private readonly int $id,
    ) {}

    /**
     * @inheritDoc
     */
    public function run(...$params): mixed
    {
        MetricHistoryRun::find($this->id)
            ?->update([
                'saved' => true,
            ]);

        return true;
    }
}
