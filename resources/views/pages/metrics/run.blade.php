@extends('layouts.main')

@section('title') Metrics Run @endsection

@section('content')
    <div class="bg-white">
        <div class="flex flex-row mb-4">
            <h2 class="text-lg font-medium text-gray-900">Run metrics for a specified Webpage</h2>
            <div class="ml-auto">
                <button type="submit"
                        class="opacity-on-run-wait run-metrics-button flex items-center rounded-md bg-indigo-50 px-2.5 py-1.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100 ml-auto">                    <span class="mr-2">
                        Run Metrics
                    </span>
                    <svg class="opacity-on-run-wait w-6 h-6 ml-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>

        <section id="metric-failed-container" class="bg-gray-50 sm:px-6 rounded-3xl p-3 mb-2 mt-3 flex flex-col items-center text-center hidden">
            <div class="mb-2 font-bold text-red-400">The Benchmark was failed</div>
            <div class="flex flex-row">
                <div class="text-sm mb-3 font-semibold">
                    <span id="metric-result-error-message" class="text-red-400">An Error message.</span>
                </div>
            </div>
        </section>

        <section id="loading-metric-run-container" class="hidden">
            <div class="bg-gray-100 rounded-3xl p-5 my-5 flex flex-col items-center">
                <div class="font-bold text-mb mb-5">Running Benchmarks</div>
                <div class="flex flex-row">
                    <div style="border-top-color:transparent;"
                         class="w-9 h-9 border-4 border-indigo-500 border-double rounded-full animate-spin"></div>
                    <div class="text-xs my-auto ml-6 font-semibold">
                        <span id="loading-time"></span>s
                    </div>
                </div>
                <div id="loading-message" class="mt-3 mb-1 text-sm text-center"></div>
                <div class="mt-1 text-sm font-semibold text-center">When it finishes, you will be redirected to the result page.</div>
            </div>
        </section>

        <div class="mt-2 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-10">
            <section class="opacity-on-run-wait">
                @include('components.pages.run.categorySelector', $categories)
            </section>

            <section class="opacity-on-run-wait">
                <form class="" onsubmit="event.preventDefault();" novalidate>
                    <div class="mx-auto max-w-lg lg:max-w-none">
                        <section id="input-page-url-section" class="opacity-on-run-wait mb-4">
                            @include('components.pages.run.pageURLInput')
                        </section>

                        <section id="strategy-selector-section" class="opacity-on-run-wait">
                            @include('components.pages.run.strategySelector', $strategies)
                        </section>
                    </div>
                </form>
            </section>
        </div>

        <button type="submit"
                class="opacity-on-run-wait lg:hidden run-metrics-button flex items-center rounded-md bg-indigo-50 px-2.5 py-1.5 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100 ml-auto">                    <span class="mr-2">
                        Run Metrics
                    </span>
            <svg class="opacity-on-run-wait w-6 h-6 ml-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </button>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const runMetricsButtons = document.querySelectorAll('.run-metrics-button')
        const metricsInputUrl = document.getElementById('metrics-url')
        const loadingMetricRunContainer = document.getElementById('loading-metric-run-container')
        const opacityOnWait = document.querySelectorAll('.opacity-on-run-wait')
        const metricsResultContainer = document.getElementById('metric-failed-container')
        const metricsResultErrMssg = document.getElementById('metric-result-error-message')

        let isLoadingRun = false
        let timeCount = 0
        const loadingTimeInterval = 500

        const callUntilLoadFinishes = (fn, msMin, msMax = 0) => {
            msMax = msMax === 0 ? msMin : msMax

            if(isLoadingRun){
                const ms = window.helpers.Random.getRandomInterval(msMin, msMax)

                setTimeout(() => {
                    fn()
                    callUntilLoadFinishes(fn, msMin, msMax)
                }, ms)
            }
        }

        const toggleLoading = () => {
            metricsResultContainer.classList.add('hidden')

            timeCount = 0
            isLoadingRun = !isLoadingRun

            loadingMetricRunContainer.classList.toggle('hidden')

            opacityOnWait.forEach(el => {
                el.classList.toggle('opacity-40')
            })

            runMetricsButtons.forEach(el => {
                el.disabled = !el.disabled
            })

            const changeMessage = () => {
                document.getElementById('loading-message').textContent = window.loadingMessages.getRandomMessage()
            }

            const changeLoadingTime = () => {
                timeCount = ((Number.parseFloat(timeCount) + (loadingTimeInterval / 1000))).toFixed(1)
                document.getElementById('loading-time').textContent = timeCount.toString()
            }

            changeLoadingTime()
            changeMessage()
            callUntilLoadFinishes(changeMessage, 2500, 7000)
            callUntilLoadFinishes(changeLoadingTime, loadingTimeInterval)
        }

        runMetricsButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                if(window.forms.checkValidations()) {
                    toggleLoading()

                    window.services.internal.MetricsService.run(
                        metricsInputUrl.value,
                        window.forms.getSelectedStrategy(),
                        window.forms.getSelectedCategories()
                    ).then(response => {
                        toggleLoading()

                        if (response.data.success) {
                            metricsResultContainer.classList.add('hidden')
                            location.href = "{{ route('metrics.detail') }}?id="+response.data.metricHistoryRunId;
                        } else {
                            metricsResultContainer.classList.remove('hidden')
                            metricsResultErrMssg.textContent = response.data.code.toString() + ': ' + response.data.message
                        }
                    }).catch(error => {
                        console.log(error)
                    })
                } else {
                    ['metrics-url-errors', 'categories-errors'].map(errors => {
                        const el = document.getElementById(errors)
                        el.classList.add('animate-bounce')

                        setTimeout(() =>{
                            el.classList.remove('animate-bounce')
                        }, 5000)
                    })

                    document.querySelector('#strategy-selector-section').scrollIntoView({
                        behavior: 'smooth'
                    })
                }
            })
        })
    })
</script>
