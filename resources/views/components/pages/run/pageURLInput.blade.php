<h2 id="metrics-url-label" class="block text-lg font-medium text-gray-900 mb-2">Metrics Webpage</h2>

<input id="metrics-url" maxlength="250" minlength="2" value="broobe.com" type="url" name="url"
       placeholder="broobe.com" aria-labelledby="metrics-url-label" autocomplete
       class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-600">

<p id="metrics-url-validated" class="mt-2 text-sm text-gray-500 text-left hidden">It will take at least 20-30 seconds.</p>
<p id="metrics-url-errors" class="mt-2 text-sm text-red-500 text-left duration-1000">It has to be a valid URL between 3 and 250 chars.</p>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const metricsInputUrl = document.getElementById('metrics-url')
        const metricsInputUrlLabel = document.getElementById('metrics-url-label')
        const metricsUrlErrors = document.getElementById('metrics-url-errors')
        const metricsUrlValid = document.getElementById('metrics-url-validated')

        const setIsUrlInputValid = (condition) => {
            window.forms.validations.isUrlInputValid = condition

            if (condition) {
                metricsUrlErrors.classList.add('hidden')
                metricsUrlValid.classList.remove('hidden')

                metricsInputUrlLabel.classList.remove('text-red-700')
                metricsInputUrl.classList.remove('border-red-300')
                metricsInputUrl.classList.remove('focus:border-red-500')
                metricsInputUrl.classList.remove('focus:ring-red-500')

                metricsInputUrlLabel.classList.add('text-gray-700')
                metricsInputUrl.classList.add('border-gray-300')
                metricsInputUrl.classList.add('focus:border-indigo-500')
                metricsInputUrl.classList.add('focus:ring-indigo-500')
                metricsInputUrl.classList.add('focus:ring-indigo-500')
            } else {
                metricsUrlErrors.classList.remove('hidden')
                metricsUrlValid.classList.add('hidden')

                metricsInputUrlLabel.classList.remove('text-gray-700')
                metricsInputUrl.classList.remove('border-gray-300')
                metricsInputUrl.classList.remove('focus:border-indigo-500')
                metricsInputUrl.classList.remove('focus:ring-indigo-500')

                metricsInputUrlLabel.classList.add('text-red-700')
                metricsInputUrl.classList.add('border-red-300')
                metricsInputUrl.classList.add('focus:border-red-500')
                metricsInputUrl.classList.add('focus:ring-red-500')
            }
        }

        const validateMetricsInputUrl = () => {
            const urlRegex = /^((https?:\/\/)?([a-z0-9.-]+)\.([a-z]{2,6}\.?)(\/\S*)?)$/i;

            setIsUrlInputValid(
                metricsInputUrl.value.length >= 3
                && metricsInputUrl.value.length <= 250
                && urlRegex.test(metricsInputUrl.value)
            )
        }

        validateMetricsInputUrl()

        metricsInputUrl.addEventListener('input', validateMetricsInputUrl)
    });
</script>
