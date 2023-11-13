<script>
    document.addEventListener("DOMContentLoaded", async function() {
        const japaneseElement = document.querySelector("#unfamiliarCardFront h5");
        const koreanElement = document.querySelector("#unfamiliarCardFront p");
        const koreanDefinitionElement = document.querySelector("#unfamiliarCardBack p");
        const nextButton = document.getElementById('unfamiliarCardNextButton');
        const favoriteButton = document.getElementById('unfamiliarCardFavoriteButton');
        const memorizedButton = document.getElementById('unfamiliarCardMemorizedButton');

        let wordId = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch('/unfamiliar-word')
        const data = await response.json();

        console.log(data.word);

        if (data) {
            japaneseElement.textContent = data.word.japanese;
            koreanElement.textContent = data.word.korean;
            koreanDefinitionElement.textContent = data.word.korean_definition;
            wordId = data.word.word_number;
        } else {
            japaneseElement.textContent = '';
            koreanElement.textContent = '';
            koreanDefinitionElement.textContent = '';
        }

        favoriteButton.addEventListener('click', function() {
            updateWordStatus(wordId, 'favorite');
        });

        memorizedButton.addEventListener('click', function() {
            updateWordStatus(wordId, 'memorized');
        });

        nextButton.addEventListener("click", async function() {
            const response = await fetch(`/next-unfamiliar-word?word_number=${wordId}`);
            const data = await response.json();

            if (data) {
                japaneseElement.textContent = data.japanese;
                koreanElement.textContent = data.korean;
                koreanDefinitionElement.textContent = data.korean_definition;
                wordId = data.word_number;

                const card = document.getElementById('unfamiliarCard');
                card.style.transform = 'rotateY(0deg)';
            } else {
                japaneseElement.textContent = '';
                koreanElement.textContent = '';
                koreanDefinitionElement.textContent = '';
            }
        });

        function updateWordStatus(wordId, status) {
            fetch(`/user-words/${wordId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            });
        }

        function loadUnfamiliarWordForm() {
            document.getElementById('unfamiliarCardFlipButton').addEventListener('click', function() {
                const card = document.getElementById('unfamiliarCard');
                card.style.transform = 'rotateY(180deg)';
            });

            document.getElementById('unfamiliarCardUnflipButton').addEventListener('click', function() {
                const card = document.getElementById('unfamiliarCard');
                card.style.transform = 'rotateY(0deg)';
            });
        }
        loadUnfamiliarWordForm();
    });

</script>

<style>
    .unfamiliar-modal-class {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .unfamiliar-modal-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        width: 800px;
        height: 600px;
        background-color: transparent;
    }
    .unfamiliar-header {
        width: 50%;
        text-align: center;
    }
    .unfamiliar-card-wrapper {
        border: 2px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
    }
    .unfamiliar-card-container {
        width: 70%;
        border-radius: 5px;
        padding: 20px;
        margin-top: 20px;
    }
    .unfamiliar-button-container {
        width: 30%;
        border-radius: 5px;
        padding: 20px;
        margin-top: 20px;
    }
    .unfamiliar-center-elements {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .unfamiliar-button-elements {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
      flex-direction: column;
    }
    .unfamiliar-cursor-pointer {
      cursor: pointer;
    }
    .unfamiliar-input-field {
      padding: 10px;
      width: 100%;
      height: 50px;
      border: 1px solid #ddd;
    }
    .unfamiliar-tag-header {
      font-size: 1.2em;
      font-weight: bold;
      margin-bottom: 1em;
      text-align: center;
    }
</style>

<section class="unfamiliar-modal-class">
    <div class="unfamiliar-modal-content">
        <header class="unfamiliar-header">
            <h2 class="text-lg font-medium text-white-900">
                {{ __('知らないリスト') }}
            </h2>
            <p class="mt-1 text-sm text-white-600">
                {{ __('知らなかった用語をまとめて見ることができます。') }}
            </p>
        </header>
        
        <div class="unfamiliar-card-wrapper">
            <div class="unfamiliar-card-container">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg unfamiliar-center-elements">
                    <div class="p-6 text-gray-900">
                        <!-- Card contents -->
                        <div class="relative mt-6 w-96 rounded-xl overflow-hidden shadow-md">
                        <div id="unfamiliarCard" class="relative w-full h-64 transform-gpu transition-transform duration-1000 ease-in-out">
                            <div id="unfamiliarCardFront" class="absolute w-full h-full bg-white flex flex-col p-6 items-center justify-center">
                            <h5 class="mb-2 font-sans text-xl font-semibold text-black text-center"></h5>
                            <p class="font-sans text-lg font-light text-black text-center"></p>
                            <button id="unfamiliarCardFlipButton" class="mt-6 px-4 py-2 bg-pink-500 text-white rounded-lg">詳しく</button>
                            </div>
                            <div id="unfamiliarCardBack" class="absolute w-full h-full bg-white flex flex-col p-6 items-start items-center justify-center justify-between backface-hidden rotate-y-180">
                            <p class="font-sans text-lg font-light text-black text-center"></p>
                            <button id="unfamiliarCardUnflipButton" class="mt-auto px-4 py-2 bg-blue-500 text-white rounded-lg">戻り</button>
                            </div>        
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="unfamiliar-button-container">
                <div class="unfamiliar-button-elements">
                    <button id="unfamiliarCardFavoriteButton" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">気に入り</button>
                    <button id="unfamiliarCardMemorizedButton" class="px-4 py-2 bg-green-500 text-white rounded-lg">知らない</button>
                    <button id="unfamiliarCardNextButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg">次</button>
                    <x-danger-button
                        x-data=""
                        @click.prevent="closeModal()"
                    >{{ __('Close') }}
                    </x-danger-button>
                </div>
            </div>
        </div>
    </div>
</section>
