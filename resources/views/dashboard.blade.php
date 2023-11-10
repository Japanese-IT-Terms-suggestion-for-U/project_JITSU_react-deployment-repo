<script>
    document.addEventListener("DOMContentLoaded", function() {
        const japaneseElement = document.querySelector("#cardFront h5");
        const koreanElement = document.querySelector("#cardFront p");
        const koreanDefinitionElement = document.querySelector("#cardBack p");
        const nextButton = document.getElementById('nextButton');

        if (nextButton) {
            console.log("nextButton selected successfully!");
        } else {
            console.error("Failed to select nextButton!");
        }

        nextButton.addEventListener("click", function() {
            console.log("Next button clicked!");

            fetch("/random-word")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(word => {
                    console.log(word);
                    japaneseElement.textContent = word.japanese;
                    koreanElement.textContent = word.korean;
                    koreanDefinitionElement.textContent = word.korean_definition;
                })
                .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
                });
        });
    });
</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->name }}{{ __('様、ようこそ！') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center justify-center">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center">
                    <!-- Card contents -->
                    <x-card :word="$word" />
                    <button id="nextButton">&gt;</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
