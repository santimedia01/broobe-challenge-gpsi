@php
    $urlParts = parse_url($metricHistoryRun->url ?? '');
    $urlParts['path'] ??= ''
@endphp

@extends('layouts.main')

@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <div class="">
        <div class="flex flex-row mb-4">
            <h2 class="text-lg font-medium text-gray-900">
                Metrics Results
                @if($metricHistoryRun)
                    - {{ $urlParts['host'] }}
                @endif
            </h2>
            @if($metricHistoryRun)
                <div class="ml-auto flex flex-col md:flex-row my-auto mt-3 md:mt-0">
                    <div class="flex items-center gap-x-1.5 mr-3 mx-auto">
                        <div class="flex-none rounded-full bg-emerald-500/20 p-1">
                            <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
                        </div>
                        <p class="text-xs leading-5 text-gray-500">Online</p>
                    </div>
                    <div class="flex flex-row text-indigo-600">
                        <a href="{{ $metricHistoryRun->url }}" target="_blank" class="mr-1">{{ $urlParts['host'] }}</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 mt-0.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>
                </div>
            @endif
        </div>

        @if($metricHistoryRun === null)
            <div class="mb-2">This benchmark result does not exist.</div>
            <div>Please run a metrics benchmark to see its result.</div>
        @else
            @php
                $order = [
                    'seo_metric' => $metricHistoryRun->seo_metric,
                    'performance_metric' => $metricHistoryRun->performance_metric,
                    'best_practices_metric' => $metricHistoryRun->best_practices_metric,
                    'accessibility_metric' => $metricHistoryRun->accessibility_metric,
                ];

                arsort($order);
            @endphp
            <div class="text-gray-500 text-sm -mt-4 mb-4 flex flex-col">
                <span>({{ $metricHistoryCount }} total metric results)</span>
                <span class="mb-2">Tested on a {{ strtolower($metricHistoryRun->strategy->inputValue) }} device at {{ $metricHistoryRun->created_at }}</span>
            </div>
            <button id="save-on-db-button" type="submit"
                    class="flex items-center rounded-md bg-indigo-50 px-2.5 py-1.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100" @disabled($metricHistoryRun->saved)>
                <span class="mr-2">
                    Save Metrics on Database @if($metricHistoryRun->saved) (already saved) @endif
                </span>
            </button>
            <dl role="list" class="mt-5 grid grid-cols-1 divide-y divide-x divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-2 md:divide-x md:divide-y-0">
                @foreach($order as $index => $value)
                    <div class="px-4 py-5 sm:p-6 max-w-96">
                        @if($metricHistoryRun->{$index} > 0)
                            <figure class="highcharts-{{$index}}">
                                <div id="highchart-{{$index}}"></div>
                            </figure>
                        @else
                            The {{$index}} was not selected during test.
                        @endif
                    </div>
                @endforeach

                <script>
                    @if($metricHistoryRun->seo_metric > 0)

                    Highcharts.chart('highchart-seo_metric', {
                        exporting: {
                            enabled: false
                        },
                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false,
                            height: '60%'
                        },

                        title: {
                            text: 'SEO',
                            style: {
                                color: '#4f46e5',
                            },
                        },

                        pane: {
                            startAngle: -90,
                            endAngle: 110,
                            background: null,
                            center: ['50%', '75%'],
                            size: '120%'
                        },

                        yAxis: {
                            min: 0,
                            max: 1,
                            tickPixelInterval: 50,
                            tickPosition: 'inside',
                            tickColor: '#5f0aff',
                            tickLength: 8,
                            tickWidth: 5,
                            minorTickInterval: null,
                            labels: {
                                distance: 20,
                                style: {
                                    fontSize: '14px',
                                    color: '#4f46e5',
                                }
                            },
                            lineWidth: 4,
                            lineColor: '#6a20f5',
                            plotBands: [{
                                from: 0.0,
                                to: 0.61,
                                color: '#574fe3',
                                thickness: 20
                            }, {
                                from: 0.6,
                                to: 0.81,
                                color: '#7974e8',
                                thickness: 18
                            }, {
                                from: 0.8,
                                to: 1,
                                color: '#908ced',
                                thickness: 15
                            }]
                        },

                        series: [{
                            name: 'Score',
                            data: [
                                {{ $metricHistoryRun->seo_metric }}
                            ],
                            tooltip: {
                                valueSuffix: ' Score'
                            },
                            dataLabels: {
                                format: '{y} Score',
                                borderWidth: 0,
                                color: '#4f46e5',
                                style: {
                                    fontSize: '15px'
                                }
                            },
                            dial: {
                                radius: '130%',
                                backgroundColor: '#4e46e5',
                                baseWidth: 15,
                                baseLength: '0%',
                                rearLength: '0%'
                            },
                            pivot: {
                                backgroundColor: '#4e46e5',
                                radius: 15
                            }
                        }]
                    });
                    @endif

                    @if($metricHistoryRun->performance_metric > 0)
                    Highcharts.chart('highchart-performance_metric', {
                        exporting: {
                            enabled: false
                        },
                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false,
                            height: '60%'
                        },

                        title: {
                            text: 'Performance',
                            style: {
                                color: '#4f46e5',
                            },
                        },

                        pane: {
                            startAngle: -90,
                            endAngle: 110,
                            background: null,
                            center: ['50%', '75%'],
                            size: '120%'
                        },

                        yAxis: {
                            min: 0,
                            max: 1,
                            tickPixelInterval: 50,
                            tickPosition: 'inside',
                            tickColor: '#5f0aff',
                            tickLength: 8,
                            tickWidth: 5,
                            minorTickInterval: null,
                            labels: {
                                distance: 20,
                                style: {
                                    fontSize: '14px',
                                    color: '#4f46e5',
                                }
                            },
                            lineWidth: 4,
                            lineColor: '#6a20f5',
                            plotBands: [{
                                from: 0.0,
                                to: 0.61,
                                color: '#574fe3',
                                thickness: 20
                            }, {
                                from: 0.6,
                                to: 0.81,
                                color: '#7974e8',
                                thickness: 18
                            }, {
                                from: 0.8,
                                to: 1,
                                color: '#908ced',
                                thickness: 15
                            }]
                        },

                        series: [{
                            name: 'Score',
                            data: [
                                {{ $metricHistoryRun->performance_metric }}
                            ],
                            tooltip: {
                                valueSuffix: ' Score'
                            },
                            dataLabels: {
                                format: '{y} Score',
                                borderWidth: 0,
                                color: '#4f46e5',
                                style: {
                                    fontSize: '15px'
                                }
                            },
                            dial: {
                                radius: '130%',
                                backgroundColor: '#4e46e5',
                                baseWidth: 15,
                                baseLength: '0%',
                                rearLength: '0%'
                            },
                            pivot: {
                                backgroundColor: '#4e46e5',
                                radius: 15
                            }
                        }]
                    });
                    @endif

                    @if($metricHistoryRun->accessibility_metric > 0)
                    Highcharts.chart('highchart-accessibility_metric', {
                        exporting: {
                            enabled: false
                        },
                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false,
                            height: '60%'
                        },

                        title: {
                            text: 'Accessibility',
                            style: {
                                color: '#4f46e5',
                            },
                        },

                        pane: {
                            startAngle: -90,
                            endAngle: 110,
                            background: null,
                            center: ['50%', '75%'],
                            size: '120%'
                        },

                        yAxis: {
                            min: 0,
                            max: 1,
                            tickPixelInterval: 50,
                            tickPosition: 'inside',
                            tickColor: '#5f0aff',
                            tickLength: 8,
                            tickWidth: 5,
                            minorTickInterval: null,
                            labels: {
                                distance: 20,
                                style: {
                                    fontSize: '14px',
                                    color: '#4f46e5',
                                }
                            },
                            lineWidth: 4,
                            lineColor: '#6a20f5',
                            plotBands: [{
                                from: 0.0,
                                to: 0.61,
                                color: '#574fe3',
                                thickness: 20
                            }, {
                                from: 0.6,
                                to: 0.81,
                                color: '#7974e8',
                                thickness: 18
                            }, {
                                from: 0.8,
                                to: 1,
                                color: '#908ced',
                                thickness: 15
                            }]
                        },

                        series: [{
                            name: 'Score',
                            data: [
                                {{ $metricHistoryRun->accessibility_metric }}
                            ],
                            tooltip: {
                                valueSuffix: ' Score'
                            },
                            dataLabels: {
                                format: '{y} Score',
                                borderWidth: 0,
                                color: '#4f46e5',
                                style: {
                                    fontSize: '15px'
                                }
                            },
                            dial: {
                                radius: '130%',
                                backgroundColor: '#4e46e5',
                                baseWidth: 15,
                                baseLength: '0%',
                                rearLength: '0%'
                            },
                            pivot: {
                                backgroundColor: '#4e46e5',
                                radius: 15
                            }
                        }]
                    });
                    @endif

                    @if($metricHistoryRun->best_practices_metric > 0)
                    Highcharts.chart('highchart-best_practices_metric', {
                        exporting: {
                            enabled: false
                        },
                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false,
                            height: '60%'
                        },

                        title: {
                            text: 'Best Practices',
                            style: {
                                color: '#4f46e5',
                            },
                        },

                        pane: {
                            startAngle: -90,
                            endAngle: 110,
                            background: null,
                            center: ['50%', '75%'],
                            size: '120%'
                        },

                        yAxis: {
                            min: 0,
                            max: 1,
                            tickPixelInterval: 50,
                            tickPosition: 'inside',
                            tickColor: '#5f0aff',
                            tickLength: 8,
                            tickWidth: 5,
                            minorTickInterval: null,
                            labels: {
                                distance: 20,
                                style: {
                                    fontSize: '14px',
                                    color: '#4f46e5',
                                }
                            },
                            lineWidth: 4,
                            lineColor: '#6a20f5',
                            plotBands: [{
                                from: 0.0,
                                to: 0.61,
                                color: '#574fe3',
                                thickness: 20
                            }, {
                                from: 0.6,
                                to: 0.81,
                                color: '#7974e8',
                                thickness: 18
                            }, {
                                from: 0.8,
                                to: 1,
                                color: '#908ced',
                                thickness: 15
                            }]
                        },

                        series: [{
                            name: 'Score',
                            data: [
                                {{ $metricHistoryRun->best_practices_metric }}
                            ],
                            tooltip: {
                                valueSuffix: ' Score'
                            },
                            dataLabels: {
                                format: '{y} Score',
                                borderWidth: 0,
                                color: '#4f46e5',
                                style: {
                                    fontSize: '15px'
                                }
                            },
                            dial: {
                                radius: '130%',
                                backgroundColor: '#4e46e5',
                                baseWidth: 15,
                                baseLength: '0%',
                                rearLength: '0%'
                            },
                            pivot: {
                                backgroundColor: '#4e46e5',
                                radius: 15
                            }
                        }]
                    });
                    @endif

                    const saveBtn = document.getElementById('save-on-db-button')

                    saveBtn.addEventListener('click', async el =>{
                        const response = await window.services.internal.MetricsService.save({{$metricHistoryRun->id}})

                        if (response.success) {
                            saveBtn.textContent += '(saved)'
                            saveBtn.disabled = true
                        }
                    })
                </script>
            </dl>
        @endif
    </div>

@endsection


