<x-app-layout>
    <div class="flex items-center justify-center min-h-screen overflow-auto bg-gradient-to-r from-gray-500 bg-gray-100 dark:bg-gray-900 dark:dark:text-gray-200">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center justify-center">
            <h1 class="text-2xl font-bold mb-4">コミュニティ</h1>
            <p>現在作業中</p>
            <div class="w-full max-w-md">
                <ul>
                    {{-- @foreach ($messages as $message)
                        <li class="mb-4">
                            <h2 class="text-lg font-bold">{{ $message->title }}</h2>
                            <p class="text-gray-700">{{ $message->content }}</p>
                        </li>
                    @endforeach --}}
                </ul>
            </div>
        </div>
    </div>
    
    {{-- Footer --}}
    <x-footer />
</x-app-layout>