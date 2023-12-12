<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const japaneseElement = document.querySelector("#unfamiliarCardFront h5");
        const tagElement = document.querySelector("#unfamiliarCardFront #tag");
        const koreanElement = document.querySelector("#unfamiliarCardFront #korean");
        const koreanDefinitionElement = document.querySelector("#unfamiliarCardBack p");
        const nextButton = document.getElementById("unfamiliarCardNextButton");
        const favoriteButton = document.getElementById("unfamiliarCardFavoriteButton");
        const memorizedButton = document.getElementById("unfamiliarCardMemorizedButton");

        let wordId = null;

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        try {
            const response = await fetch("/unfamiliar-word");
            const data = await response.json();
            wordId = data.word.id;
            const statusResponse = await fetch(`/word-status/${wordId}`);
            const wordStatus = await statusResponse.json();

            if (data) {
                japaneseElement.textContent = data.word.japanese;
                tagElement.textContent = data.word.tag.tag_name;
                koreanElement.textContent = data.word.korean;
                koreanDefinitionElement.textContent = data.word.korean_definition;

                updateButtonStatus(favoriteButton, "favorite", wordStatus.is_favorite);
                updateButtonStatus(memorizedButton, "memorized", wordStatus.is_memorized);
            } else {
                japaneseElement.textContent = "なし";
                tagElement.textContent = "";
                koreanElement.textContent = "";
                koreanDefinitionElement.textContent = "";
            }
        } catch (error) {
            console.error("There has been a problem with your fetch operation:", error);
        }

        nextButton.addEventListener("click", async function () {
            try {
                const response = await fetch(`/next-unfamiliar-word?wordId=${wordId}`);
                const data = await response.json();
                console.log(data);

                if (data) {
                    wordId = data.id;
                    const statusResponse = await fetch(`/word-status/${wordId}`);
                    const wordStatus = await statusResponse.json();

                    japaneseElement.textContent = data.japanese;
                    tagElement.textContent = data.tag.tag_name;
                    koreanElement.textContent = data.korean;
                    koreanDefinitionElement.textContent = data.korean_definition;

                    updateButtonStatus(favoriteButton, "favorite", wordStatus.is_favorite);
                    updateButtonStatus(memorizedButton, "memorized", wordStatus.is_memorized);
                } else {
                    japaneseElement.textContent = "なし";
                    tagElement.textContent = "";
                    koreanElement.textContent = "";
                    koreanDefinitionElement.textContent = "";
                }
            } catch (error) {
                console.error("There has been a problem with your fetch operation:", error);
            }
        });

        favoriteButton.addEventListener("click", async function () {
            await handleButtonClick(favoriteButton, "favorite");
        });

        memorizedButton.addEventListener("click", async function () {
            await handleButtonClick(memorizedButton, "memorized");
        });

        async function handleButtonClick(button, status) {
            const updatedStatus = await updateWordStatus(wordId, status);
            const isStatusSet = status === "favorite" ? updatedStatus.is_favorite : updatedStatus.is_memorized;

            updateButtonStatus(button, status, isStatusSet);
        }

        async function updateWordStatus(wordId, status) {
            try {
                const response = await fetch(`/user-words/${wordId}`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({ status }),
                });
                const data = await response.json();

                console.log(data);
                return data;
            } catch (error) {
                console.error(
                    "There has been a problem with your fetch operation:",
                    error
                );
            }
        }

        function updateButtonStatus(button, statusKey, statusValue) {
            console.log(`Updating button status: ${statusKey}, ${statusValue}`);
            if (statusValue) {
                button.classList.add('active');
                statusKey === 'favorite' ? button.textContent = '気に入り削除' : button.textContent = '知っている';
            } else {
                button.classList.remove('active');
                statusKey === 'favorite' ? button.textContent = '気に入り' : button.textContent = '知らない';
            }
        }

        function flipCard(cardId, transformValue) {
            const card = document.getElementById(cardId);
            card.style.transform = transformValue;
        }

        function loadFavoriteWordForm() {
            document
                .getElementById("unfamiliarCardFlipButton")
                .addEventListener("click", () =>
                    flipCard("unfamiliarCard", "rotateY(180deg)")
                );
            document
                .getElementById("unfamiliarCardUnflipButton")
                .addEventListener("click", () =>
                    flipCard("unfamiliarCard", "rotateY(0deg)")
                );
        }

        loadFavoriteWordForm();
    });
</script>

<style>
    button {
        transition: transform 0.1s ease;
    }
    button:active {
        transform: scale(0.95);
    }
    .unfamiliarCardBackContent {
        overflow: auto;
        max-height: 150px;
    }
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
        width: 20%;
        text-align: center;
        padding: 20px 0;
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
    <header class="unfamiliar-header">
        <h2 class="text-lg font-medium text-white">
            {{ __('知らないリスト') }}
        </h2>
        <p class="mt-1 text-sm text-white">
            {{ __('知らなかった用語をまとめて見ることができます。') }}
        </p>
    </header>
    
    <div class="unfamiliar-modal-content">
        <div class="unfamiliar-card-wrapper">
            <div class="unfamiliar-card-container">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg unfamiliar-center-elements">
                    <div class="p-6 text-gray-900">
                        <!-- Card contents -->
                        <div class="relative mt-6 w-96 rounded-xl overflow-hidden shadow-md">
                            <div id="unfamiliarCard" class="relative w-full h-64 transform-gpu transition-transform duration-1000 ease-in-out">
                                <div id="unfamiliarCardFront" class="absolute w-full h-full bg-white flex flex-col p-6 items-center justify-center">
                                    <h5 class="mb-2 font-sans text-xl font-semibold text-black text-center"></h5>
                                    <p id="tag" class="tag font-sans text-sm font-light text-black text-center"></p>
                                    <p id="korean" class="font-sans text-lg font-light text-black text-center"></p>
                                    <button id="unfamiliarCardFlipButton" class="mt-6 px-4 py-2 bg-pink-500 text-white rounded-lg">詳しく</button>
                                </div>
                                <div id="unfamiliarCardBack" class="absolute w-full h-full bg-white flex flex-col p-6 items-start items-center justify-center justify-between backface-hidden rotate-y-180">
                                    <p class="unfamiliarCardBackContent font-sans text-lg font-light text-black text-center"></p>
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
