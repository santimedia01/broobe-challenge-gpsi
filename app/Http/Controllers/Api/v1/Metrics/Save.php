<?php

namespace App\Http\Controllers\Api\v1\Metrics;

use App\Actions\v1\Metrics\RunMetrics;
use App\Actions\v1\Metrics\SaveMetrics;
use App\Enums\CategoryEnum;
use App\Enums\StrategyEnum;
use App\Http\Controllers\Controller;
use App\Infra\DataObjects\ErrorResponse;
use App\Infra\DataObjects\SuccessResponse;
use App\Infra\Interfaces\PageSpeedServiceInterface;
use App\Infra\URLValueObject;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class Save extends Controller
{
    public function __invoke(int $id)
    {
        (new SaveMetrics($id))
            ->run();

        return response()->json([
            'success' => true,
        ]);
    }
}

