<?php

namespace App\Infra\DataObjects\PageSpeedService;

use App\Enums\CategoryEnum;
use App\Infra\DataObjects\SuccessResponse;
use App\Infra\Traits\Arrayable;

class PageSpeedServiceSuccessResponseData extends SuccessResponse
{
    use Arrayable;

    public function __construct(
        private readonly RunBenchmarkInputData $input,
        private readonly array $scores,
    ) {
        parent::__construct();
    }

    public function getPerformanceScore(): float
    {
        return $this->scores[CategoryEnum::Performance->value] ?? -1;
    }

    public function getAccessibilityScore(): float
    {
        return $this->scores[CategoryEnum::Accessibility->value] ?? -1;
    }

    public function getSEOScore(): float
    {
        return $this->scores[CategoryEnum::SEO->value] ?? -1;
    }

    public function getBestPracticesScore(): float
    {
        return $this->scores[CategoryEnum::BestPractices->value] ?? -1;
    }
}
