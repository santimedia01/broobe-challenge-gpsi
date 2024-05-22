@php
    $icons = [
        'MOBILE' => '
            <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
            </svg>
        ',
        'DESKTOP' => '
            <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
            </svg>
        ',
    ];
@endphp

<h2 id="billing-heading" class="text-lg font-medium text-gray-900 mb-2">Select Metrics Strategy</h2>
<img id="description-image"
     src="{{ asset('storage/assets/img/person-and-computer.png') }}"
     class="rounded-3xl mx-auto size-80 max-w-64 max-h-64" alt="A Man in front of a Computer" />
<form id="strategy-form" name="strategy" onsubmit="event.preventDefault()">
    <fieldset>
        <legend class="text-base font-semibold leading-6 text-gray-900"></legend>
        <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
            @foreach($strategies as $strategy)
                <label id="form-strategy-label-{{ $loop->index }}"
                    class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none @if($loop->first) border-indigo-600 ring-2 ring-indigo-600 @else border-gray-300 @endif">
                    <input type="radio" name="strategy" form="strategy" value="{{ $strategy->inputValue }}"
                           class="sr-only" aria-labelledby="strategy-0-label"
                           aria-describedby="strategy-{{ $loop->index }}-description-0 strategy-{{ $loop->index }}-description-1" @checked($loop->first)>
                    <span class="flex flex-1">
                        <span class="flex flex-col">
                            <span id="strategy-{{ $loop->index }}-label" class="block text-sm font-medium text-gray-900 mb-3">
                                {{ $strategy->name }}
                            </span>
                            <div class="flex row-auto items-center text-sm">
                                {!! $icons[$strategy->inputValue] !!}
                                <span id="strategy-{{ $loop->index }}-description-0" class="ml-2 text-gray-500">Worldwide users at April 2024 by this device</span>
                            </div>

                            <span id="strategy-{{ $loop->index }}-description-1" class="mt-2 md:mt-3 text-sm font-medium text-gray-900">{{ $strategy->usedBy }}%</span>
                        </span>
                    </span>
                    <svg id="form-strategy-selector-tick-{{ $loop->index }}" class="min-h-4 h-5 min-w-4 w-5 text-indigo-600 @if(!$loop->first) invisible @endif" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                              clip-rule="evenodd"/>
                    </svg>
                </label>
            @endforeach
        </div>
    </fieldset>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const strategiesRadio = document.querySelectorAll('input[name="strategy"]')

        const changeSelectedStrategy = () => {
            strategiesRadio.forEach((radio, index) => {
                document.getElementById(`form-strategy-selector-tick-${index}`).classList.toggle('invisible')

                const selectedStrategyLabel = document.getElementById(`form-strategy-label-${index}`);

                [
                    'border-indigo-600',
                    'ring-2',
                    'ring-indigo-600',
                    'border-gray-300'
                ].forEach((className) => selectedStrategyLabel.classList.toggle(className))
            });
        }

        window.forms.getSelectedStrategy = () => {
            let value = '{{ $strategies[0]->inputValue }}'

            strategiesRadio.forEach((radio) => {
                if(radio.checked) {
                    value = radio.value
                }
            });

            return value
        }

        strategiesRadio.forEach(function (strategy) {
            strategy.addEventListener('change', changeSelectedStrategy)
        })
    })
</script>
