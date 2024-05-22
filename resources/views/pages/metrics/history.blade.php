@extends('layouts.main')

@section('content')
    <h2 class="text-lg font-medium text-gray-900">
        Metrics History Results
    </h2>
    <div class="text-sm md:hidden">
        Browse the table by moving through it.
    </div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-2 -ml-0.5 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle pl-1 sm:pr-6 lg:pr-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Platform</th>
                            <th scope="col" colspan="2" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Scores</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created At</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Saved</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">More Info</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Go to webpage</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($metrics as $metric)
                                @php
                                    $url = parse_url($metric->url);
                                    $url['path'] ??= '';
                                    $url['host'] = str_replace('www.', '', $url['host']);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="h-11 w-24 flex-shrink-0">
                                            <span class="flex rounded-lg h-11 w-18 shrink-0 items-center justify-center border border-indigo-400 text-sm font-medium text-indigo-600">
                                                {{ $metric->strategy->inputValue }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                        <div class="ml-4">
                                            <div class="text-gray-500"><strong>SEO:</strong> @if($metric->seo_metric > 0) {{ $metric->seo_metric * 100 }} % @else X @endif </div>
                                            <div class="mt-1 text-gray-500"><strong>Performance:</strong> @if($metric->performance_metric > 0) {{ $metric->performance_metric * 100 }} % @else X @endif </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                        <div class="ml-4">
                                            <div class="text-gray-500"><strong>Best Practices:</strong> @if($metric->best_practices_metric > 0) {{ $metric->best_practices_metric * 100 }} % @else X @endif </div>
                                            <div class="mt-1 text-gray-500"><strong>Accessibility:</strong> @if($metric->accessibility_metric > 0) {{ $metric->accessibility_metric * 100 }} % @else X @endif </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">{{ $metric->created_at }}</td>
                                    <td class="whitespace-nowrap px-3 py-5 text-gray-500">
                                        @if($metric->saved)
                                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                Saved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                                Unsaved
                                            </span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                        <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-sm font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                            <a href="{{ route('metrics.detail') }}?id={{ $metric->id }}" class="text-indigo-600 hover:text-indigo-900">See details</a>
                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-5 text-right text-sky-500 text-sm font-medium">
                                        <a href="{{$metric->url}}" target="_blank">{{ substr($url['host'].$url['path'], 0, 20) }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
