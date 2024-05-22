<?php

namespace App\Infra\Interfaces;

use App\Infra\DataObjects\ErrorResponse;
use App\Infra\DataObjects\PageSpeedService\PageSpeedServiceSuccessResponseData;
use App\Infra\DataObjects\PageSpeedService\RunBenchmarkInputData;

interface PageSpeedServiceInterface
{
    /**
     * Run the use case.
     *
     * @param RunBenchmarkInputData $input
     * @return ErrorResponse|mixed
     */
    public function runBenchmark(RunBenchmarkInputData $input): ErrorResponse|PageSpeedServiceSuccessResponseData;
}
