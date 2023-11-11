<script>
    const wordId = {!! json_encode($word->word_number) !!};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    window.onload = function() {
        document.getElementById('flipButton').addEventListener('click', function() {
            const card = document.getElementById('card');
            card.style.transform = 'rotateY(180deg)';
        });

        document.getElementById('unflipButton').addEventListener('click', function() {
            const card = document.getElementById('card');
            card.style.transform = 'rotateY(0deg)';
        });
    };
</script>        
<div class="relative mt-6 w-96 rounded-xl overflow-hidden shadow-md">
    <div id="card" class="relative w-full h-64 transform-gpu transition-transform duration-1000 ease-in-out">
        <div id="cardFront" class="absolute w-full h-full bg-white flex flex-col p-6 items-center justify-center">
            <h5 class="mb-2 font-sans text-xl font-semibold text-black text-center">
                {{ $word ? $word->japanese : '기본값' }}
            </h5>                
            <p class="font-sans text-lg font-light text-black text-center">
                {{ $word ? $word->korean : '기본값' }}
            </p>
            <button id="flipButton" class="mt-6 px-4 py-2 bg-pink-500 text-white rounded-lg">
                詳しく
            </button>
        </div>
        <div id="cardBack" class="absolute w-full h-full bg-white flex flex-col p-6 items-start items-center justify-center justify-between backface-hidden rotate-y-180">
            <p class="font-sans text-lg font-light text-black text-center">
                {{ $word ? $word->korean_definition : '기본값' }}
            </p>
            <button id="unflipButton" class="mt-auto px-4 py-2 bg-blue-500 text-white rounded-lg">
                戻り
            </button>
        </div>        
    </div>
</div>