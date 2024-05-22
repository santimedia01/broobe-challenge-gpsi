<?php

namespace App\Infra\DataObjects\PageSpeedService;

use App\Enums\CategoryEnum;
use App\Enums\StrategyEnum;
use App\Infra\Traits\Arrayable;
use App\Infra\URLValueObject;

class RunBenchmarkInputData
{
    use Arrayable;

    public function __construct(
        private readonly URLValueObject $url,
        private readonly StrategyEnum $strategy,
        /**
         * @var CategoryEnum[]
         */
        private readonly array $categories,
    ) {}

    /**
     * @return CategoryEnum[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return StrategyEnum
     */
    public function getStrategy(): StrategyEnum
    {
        return $this->strategy;
    }

    /**
     * @return URLValueObject
     */
    public function getUrl(): URLValueObject
    {
        return $this->url;
    }
}
