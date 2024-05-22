<?php

namespace App\Http\Controllers\Api\v1\Metrics;

use App\Actions\v1\Metrics\RunMetrics;
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

class RunMetric extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $data = $request->query();

            $data['url'] ??= 'https://www.broobe.com/es/';

            $data['strategy'] ??= StrategyEnum::Mobile->value;
            $data['strategy'] = strtoupper($data['strategy']);

            $data['categories'] ??= [CategoryEnum::Performance->value];
            $data['categories'] = is_array($data['categories']) ? $data['categories'] : [$data['categories']];
            $data['categories'] = array_map(fn ($cat) => strtoupper($cat), $data['categories']);

            $rules = [
                'url' => ['required', 'regex:/^((https?:\/\/)?([a-z0-9.-]+)\.([a-z]{2,6}\.?)(\/[^\s]*)?)$/i'],
                'strategy' => ['required', 'exists:strategies,inputValue'],
                'categories' => ['required', 'array'],
                'categories.*' => ['exists:categories,inputValue'],
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(
                    ErrorResponse::from(
                        1000,
                        'Input Data Validation Error',
                        $validator->errors()
                    )->toArray()
                , 422);
            }

            $url = URLValueObject::from($data['url']);

            $useCase = new RunMetrics(
                App::get(PageSpeedServiceInterface::class),
                $url,
                StrategyEnum::from($data['strategy']),
                CategoryEnum::getEnumArrayFromArrayValues($data['categories']),
            );

            $useCaseResult = $useCase->run();

            if ($useCaseResult->isSuccess()) {
                $metric = MetricHistoryRun::create([
                    'url' => $url->value(),
                    'strategy_id' => Strategy::whereInputvalue($data['strategy'])->first()->id,
                    'best_practices_metric' => $useCaseResult->getBestPracticesScore(),
                    'accessibility_metric' => $useCaseResult->getAccessibilityScore(),
                    'performance_metric' => $useCaseResult->getPerformanceScore(),
                    'seo_metric' => $useCaseResult->getSEOScore(),
                ]);

                return response()->json([
                    ...SuccessResponse::from()->toArray(),
                    'data' => [
                        'success' => $useCaseResult->isSuccess(),
                        'metricHistoryRunId' => $metric->id,
                    ],
                ]);
            } else {
                return response()->json([
                    ...SuccessResponse::from()->toArray(),
                    'data' => $useCaseResult->toArray(),
                ]);
            }
        } catch (Exception $e) {
            return response()->json(
                ErrorResponse::from(1999, "Internal Server Error: {$e->getMessage()}")
                    ->toArray()
            , 500);
        }
    }
}

