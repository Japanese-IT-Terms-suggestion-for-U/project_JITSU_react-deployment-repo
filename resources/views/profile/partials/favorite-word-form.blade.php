<script>
    document.addEventListener("DOMContentLoaded", async function() {
        const japaneseElement = document.querySelector("#favoriteCardFront h5");
        const koreanElement = document.querySelector("#favoriteCardFront p");
        const koreanDefinitionElement = document.querySelector("#favoriteCardBack p");
        const nextButton = document.getElementById('favoriteCardNextButton');
        const favoriteButton = document.getElementById('favoriteCardFavoriteButton');
        const memorizedButton = document.getElementById('favoriteCardMemorizedButton');

        function updateButtonStatus(buttonId, status, wordId) {
            const button = document.getElementById(buttonId);
            const isFavorite = status === 'favorite';
            const isFavoriteStatusSet = button.textContent === (isFavorite ? '気に入り' : '知らない');
            const newStatus = isFavoriteStatusSet ? (isFavorite ? '気に入り取消' : '知らない取消') : (isFavorite ? '気に入り' : '知らない');
            const alertMessage = isFavoriteStatusSet ? (isFavorite ? '気に入りリストから解除されました！' : '知らないリストから解除されました！') : (isFavorite ? '気に入りリストに追加されました！' : '知らないリストに追加されました！');
            button.textContent = newStatus;
            alert(alertMessage);
            updateWordStatus(wordId, status);
        }

        document.querySelector('.favorite-button-elements').addEventListener('click', function(e) {
            if (e.target.id === 'favoriteCardFavoriteButton' || e.target.id === 'favoriteCardMemorizedButton') {
                updateButtonStatus(e.target.id, e.target.id === 'favoriteCardFavoriteButton' ? 'favorite' : 'memorized', wordId);
            }
        });

        let wordId = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch('/favorite-word')
        const data = await response.json();

        if (data) {
            japaneseElement.textContent = data.word.japanese;
            koreanElement.textContent = data.word.korean;
            koreanDefinitionElement.textContent = data.word.korean_definition;
            wordId = data.word.id;

            const statusResponse = await fetch(`/word-status/${wordId}`);
            const wordStatus = await statusResponse.json();

            if (wordStatus.favorite) {
                favoriteButton.textContent = '気に入り取消';
                favoriteButton.onclick = function() {
                    updateWordStatus(wordId, 'favorite');
                    alert('気に入りリストから解除されました！');
                };
            }

            if (wordStatus.memorized) {
                memorizedButton.textContent = '知らない取消';
                memorizedButton.onclick = function() {
                    updateWordStatus(wordId, 'memorized');
                    alert('知らないリストから解除されました！');
                };
            }
        } else {
            japaneseElement.textContent = '';
            koreanElement.textContent = '';
            koreanDefinitionElement.textContent = '';
        }

        favoriteButton.addEventListener('click', function() {
            updateWordStatus(wordId, 'favorite');
            alert('気に入りリストに追加されました！');
        });

        memorizedButton.addEventListener('click', function() {
            updateWordStatus(wordId, 'memorized');
            alert('知らないリストに追加されました！');
        });

        nextButton.addEventListener("click", async function() {
            const response = await fetch(`/next-favorite-word?word_number=${wordId}`);
            const data = await response.json();

            console.log(data);

            if (data) {
                japaneseElement.textContent = data.japanese;
                koreanElement.textContent = data.korean;
                koreanDefinitionElement.textContent = data.korean_definition;
                wordId = data.id;

                const card = document.getElementById('favoriteCard');
                card.style.transform = 'rotateY(0deg)';

                const statusResponse = await fetch(`/word-status/${wordId}`);
                const wordStatus = await statusResponse.json();

                if (wordStatus.favorite) {
                    const newFavoriteButton = favoriteButton.cloneNode(true);
                    newFavoriteButton.textContent = '気に入り取消';
                    newFavoriteButton.onclick = function() {
                        updateWordStatus(wordId, 'favorite');
                        alert('気に入りリストから解除されました！');
                    };
                    favoriteButton.parentNode.replaceChild(newFavoriteButton, favoriteButton);
                    favoriteButton = newFavoriteButton;
                }
                if (wordStatus.memorized) {
                    const newMemorizedButton = memorizedButton.cloneNode(true);
                    newMemorizedButton.textContent = '知らない取消';
                    newMemorizedButton.onclick = function() {
                        updateWordStatus(wordId, 'memorized');
                        alert('知らないリ스트から解除されました！');
                    };
                    memorizedButton.parentNode.replaceChild(newMemorizedButton, memorizedButton);
                    memorizedButton = newMemorizedButton;
                }
            } else {
                japaneseElement.textContent = '';
                koreanElement.textContent = '';
                koreanDefinitionElement.textContent = '';
            }
        });

        fetch(`/word-status/${wordId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(wordStatus => {
            console.log(wordStatus);

            if (wordStatus.favorite) {
                favoriteButton.textContent = '気に入り取消';
                favoriteButton.onclick = function() {
                    updateWordStatus(wordId, 'favorite');
                    alert('気に入り解除されました！');
                };
            }
            if (wordStatus.memorized) {
                memorizedButton.textContent = '知らない取消';
                memorizedButton.onclick = function() {
                    updateWordStatus(wordId, 'memorized');
                    alert('知らないリストから解除されました！');
                };
            }
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
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
                let button;
                let newStatus;
                let alertMessage;

                if (status === 'favorite') {
                    button = document.getElementById('favoriteCardFavoriteButton');
                    newStatus = button.textContent === '気に入り' ? '気に入り取消' : '気に入り';
                    alertMessage = newStatus === '気に入り' ? '気に入りに追加されました！' : '気に入り解除されました！';
                } else if (status === 'memorized') {
                    button = document.getElementById('favoriteCardMemorizedButton');
                    newStatus = button.textContent === '知らない' ? '知らない取消' : '知らない';
                    alertMessage = newStatus === '知らない' ? '知らないリストに追加されました！' : '知らないリストから解除されました！';
                }

                button.textContent = newStatus;
                alert(alertMessage);
            });
        }

        function loadFavoriteWordForm() {
            document.getElementById('favoriteCardFlipButton').addEventListener('click', function() {
                const card = document.getElementById('favoriteCard');
                card.style.transform = 'rotateY(180deg)';
            });

            document.getElementById('favoriteCardUnflipButton').addEventListener('click', function() {
                const card = document.getElementById('favoriteCard');
                card.style.transform = 'rotateY(0deg)';
            });
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
    .favoriteCardBackContent {
        overflow: auto;
        max-height: 150px;
    }
    .favorite-modal-class {
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
    .favorite-modal-content {
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
    .favorite-header {
        width: 20%;
        text-align: center;
        padding: 20px 0;
    }
    .favorite-card-wrapper {
        border: 2px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
    }
    .favorite-card-container {
        width: 70%;
        border-radius: 5px;
        padding: 20px;
        margin-top: 20px;
    }
    .favorite-button-container {
        width: 30%;
        border-radius: 5px;
        padding: 20px;
        margin-top: 20px;
    }
    .favorite-center-elements {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .favorite-button-elements {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        flex-direction: column;
    }
    .favorite-cursor-pointer {
        cursor: pointer;
    }
    .favorite-input-field {
        padding: 10px;
        width: 100%;
        height: 50px;
        border: 1px solid #ddd;
    }
    .favorite-tag-header {
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 1em;
        text-align: center;
    }
</style>

<section class="favorite-modal-class">
    <header class="favorite-header">
        <h2 class="text-lg font-medium text-white-900">
            {{ __('お気に入りリスト') }}
        </h2>
        <p class="mt-1 text-sm text-white-600">
            {{ __('気になっていた用語をまとめて見ることができます。') }}
        </p>
    </header>

    <div class="favorite-modal-content">
        <div class="favorite-card-wrapper">
            <div class="favorite-card-container">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg favorite-center-elements">
                    <div class="p-6 text-gray-900">
                        <!-- Card contents -->
                        <div class="relative mt-6 w-96 rounded-xl overflow-hidden shadow-md">
                        <div id="favoriteCard" class="relative w-full h-64 transform-gpu transition-transform duration-1000 ease-in-out">
                            <div id="favoriteCardFront" class="absolute w-full h-full bg-white flex flex-col p-6 items-center justify-center">
                            <h5 class="mb-2 font-sans text-xl font-semibold text-black text-center"></h5>
                            <p class="font-sans text-lg font-light text-black text-center"></p>
                            <button id="favoriteCardFlipButton" class="mt-6 px-4 py-2 bg-pink-500 text-white rounded-lg">詳しく</button>
                            </div>
                            <div id="favoriteCardBack" class="absolute w-full h-full bg-white flex flex-col p-6 items-start items-center justify-center justify-between backface-hidden rotate-y-180">
                            <p class="favoriteCardBackContent font-sans text-lg font-light text-black text-center"></p>
                            <button id="favoriteCardUnflipButton" class="mt-auto px-4 py-2 bg-blue-500 text-white rounded-lg">戻り</button>
                            </div>        
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="favorite-button-container">
                <div class="favorite-button-elements">
                    <button id="favoriteCardFavoriteButton" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">気に入り</button>
                    <button id="favoriteCardMemorizedButton" class="px-4 py-2 bg-green-500 text-white rounded-lg">知らない</button>
                    <button id="favoriteCardNextButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg">次</button>
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
