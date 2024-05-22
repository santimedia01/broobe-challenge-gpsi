<h2 id="billing-heading" class="text-lg font-medium text-gray-900 mb-2">Select Key Metrics Insights</h2>
<p id="categories-errors" class="mt-1 text-sm text-red-500 text-left mb-4 hidden">Select at least one of the main insights for the benchmark test.</p>

<form name="strategy" onsubmit="preventDefault();">
    <fieldset>
        <legend class="sr-only">Metric Insights</legend>
        <div class="space-y-5">
            @foreach($categories as $category)
                <div class="relative flex items-start">
                    <div class="flex h-6 items-center">
                        <input id="categories-{{ $category->inputValue }}" value="{{ $category->inputValue }}" aria-describedby="categories-description"
                               name="categories" type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                               checked
                        >
                    </div>
                    <div class="ml-3 text-sm leading-6">
                        <label for="categories-{{ $category->inputValue }}" class="font-medium text-gray-900 capitalize">{{ $category->name }}</label>
                        <p id="categories-description-{{ $category->inputValue }}" class="text-gray-500">{{ $category->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </fieldset>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.forms.getSelectedCategories = () => {
            let categories = []

            categoriesCheckboxes.forEach((category) => {
                if(category.checked) {
                    categories.push(category.value)
                }
            });

            return categories
        }

        const categoriesErrors = document.getElementById('categories-errors')
        const categoriesCheckboxes = document.querySelectorAll('input[name="categories"]')

        const setIsCategoriesInputValid = (condition) => {
            window.forms.validations.isCategoriesInputValid = condition

            if (condition) {
                categoriesErrors.classList.add('hidden')
            } else {
                categoriesErrors.classList.remove('hidden')
            }
        }

        const validateCategoriesInput = () => {
            setIsCategoriesInputValid(
                window.forms.getSelectedCategories().length > 0
            )
        }

        validateCategoriesInput()

        categoriesCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', validateCategoriesInput)
        })
    })
</script>
