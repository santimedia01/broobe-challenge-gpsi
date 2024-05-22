<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Illuminate\Http\Request;

class
MetricsViewController extends Controller
{
    public function run()
    {
        $strategies = Strategy::get();
        $categories = Category::get();

        return view('pages.metrics.run', compact('strategies', 'categories'));
    }

    public function history(Request $request)
    {
        $searchFilter = $request->query('query', '');

        $metrics = MetricHistoryRun::orderByDesc('created_at')
            ->where('url', 'LIKE', "%{$searchFilter}%")
            ->with('strategy')
            ->orderBy('url')
            ->limit(500)
            ->get();

        return view('pages.metrics.history', compact('metrics'));
    }

    public function detail(Request $request)
    {
        $metricHistoryRun = MetricHistoryRun::find(
            $request->query('id')
        );

        if ($metricHistoryRun === null) {
            return view('pages.metrics.detail', compact('metricHistoryRun'));
        }

        $metricHistoryCount = MetricHistoryRun::whereUrl($metricHistoryRun->url)->count();
        $categories = Category::get();

        return view('pages.metrics.detail', compact(
            'metricHistoryRun',
            'metricHistoryCount',
            'categories',
        ));
    }
}
