<?php

namespace App\Actions\v1\Metrics;

use App\Enums\CategoryEnum;
use App\Enums\StrategyEnum;
use App\Infra\DataObjects\PageSpeedService\RunBenchmarkInputData;
use App\Infra\Interfaces\PageSpeedServiceInterface;
use App\Infra\Interfaces\UseCaseInterface;
use App\Infra\URLValueObject;

class RunMetrics implements UseCaseInterface
{
    public function __construct(
        private readonly PageSpeedServiceInterface $pageSpeedService,
        private readonly URLValueObject $url,
        private readonly StrategyEnum $strategy = StrategyEnum::Mobile,
        /**
         * @var CategoryEnum[] strict
         */
        private array $categories = [],
    ) {
        $categories ??= [CategoryEnum::Performance];

        $this->categories = is_array($categories)
            ? $categories
            : [$categories];
    }

    /**
     * @inheritDoc
     */
    public function run(...$params): mixed
    {
        return $this->pageSpeedService->runBenchmark(
            new RunBenchmarkInputData(
                $this->url,
                $this->strategy,
                $this->categories,
            )
        );
    }
}
