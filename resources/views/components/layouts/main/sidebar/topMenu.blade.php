@php
    $lastMetricRuns = \App\Models\MetricHistoryRun::select(['id', 'url', 'created_at'])
        ->with('strategy')
        ->orderByDesc('created_at')
        ->limit(100)
        ->get();

    $lastMetricRuns = $lastMetricRuns
        ->unique('url')
        ->take(6);
@endphp

<div class="font-semibold leading-6 text-indigo-200">Latest Benchmarks</div>
<ul role="list" class="-mx-2 mt-2 space-y-1">
    @if(count($lastMetricRuns) <= 0)
        <span class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-xs leading-6 font-semibold">
            There is no benchmarks.
        </span>
    @else

    @endif
    @foreach($lastMetricRuns as $lastMetricRun)
        @php
            $parts = parse_url($lastMetricRun->url);
            $betterUrl = str_replace('www.', '', $parts['host']) . ($parts['path'] ?? '');
        @endphp
        <li>
            <a href="{{route('metrics.detail')}}?id={{$lastMetricRun->id}}" class="text-indigo-200 hover:text-white hover:bg-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-indigo-400 text-sm font-medium text-white">
                    {{strtoupper(substr($betterUrl, 0, 1))}}
                </span>
                <span class="truncate my-auto" style="font-size: 12px">{{ $betterUrl }}</span>
            </a>
        </li>
    @endforeach
</ul>
