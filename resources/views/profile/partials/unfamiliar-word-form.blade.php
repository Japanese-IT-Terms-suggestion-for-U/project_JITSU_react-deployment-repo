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

              const card = document.getElementById('card');
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
  });

  window.onload = function() {
      document.getElementById('unfamiliarCardFlipButton').addEventListener('click', function() {
          const card = document.getElementById('unfamiliarCard');
          card.style.transform = 'rotateY(180deg)';
      });

      document.getElementById('unfamiliarCardUnflipButton').addEventListener('click', function() {
          const card = document.getElementById('unfamiliarCard');
          card.style.transform = 'rotateY(0deg)';
      });
  };
</script>

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center justify-center">
  <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center">
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

  <div class="flex justify-between mt-4">
      <button id="unfamiliarCardFavoriteButton" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">気に入り</button>
      <button id="unfamiliarCardMemorizedButton" class="px-4 py-2 bg-green-500 text-white rounded-lg">知らない</button>
      <button id="unfamiliarCardNextButton" class="px-4 py-2 bg-blue-500 text-white rounded-lg">次</button>
      <x-danger-button
              x-data=""
              x-on:click.prevent="window.modal.closeModal()"
      >{{ __('Close') }}
      </x-danger-button>
  </div>
</div>
