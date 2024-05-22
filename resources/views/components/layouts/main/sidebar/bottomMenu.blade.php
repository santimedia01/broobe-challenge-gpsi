@php
    $metricResultsCount = \App\Models\MetricHistoryRun::count();
    $metricResultsSavedCount = \App\Models\MetricHistoryRun::whereSaved(true)->count();
@endphp

<div class="text-xs mb-4">
    <span class="group flex gap-x-3 rounded-md font-semibold leading-6 text-indigo-200">
        <span class="mr-1 w-2">{{ $metricResultsSavedCount }}</span> Benchmarks Saved
    </span>
    <span class="group flex gap-x-3 rounded-md font-semibold leading-6 text-indigo-200">
        <span class="mr-1 w-2">{{ $metricResultsCount }}</span> Benchmarks Executed
    </span>
</div>
<a href="https://www.linkedin.com/in/santimediabilla/"
   target="_blank"
   class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white">
    <svg class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
    </svg>
    <span class="ml-2">
        By Santi Mediabilla
    </span>
    <svg class="text-indigo-100 w-4 h-4 my-auto" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
        <path d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z" />
    </svg>
</a>
