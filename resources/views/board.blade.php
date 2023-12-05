<x-app-layout>
    <script>
        window.onload = function() {
            var element = document.querySelector('.comments');
            element.scrollTop = element.scrollHeight;
        }
        
        function editComment(id) {
                var contentElement = document.getElementById('comment-content-' + id);
                var formElement = document.getElementById('comment-edit-form-' + id);
                contentElement.classList.add('fade');
                formElement.classList.add('fade');
                setTimeout(function() {
                    contentElement.classList.add('hidden');
                    formElement.style.display = 'block';
                    setTimeout(function() {
                        formElement.classList.remove('hidden');
                    }, 50);
                }, 500);
            }
    </script>
    <style>
        .fade {
            transition: opacity 0.5s;
        }
        .hidden {
            opacity: 0;
            display: none;
        }
        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .comments {
            overflow-y: auto;
            flex-grow: 1;
        }
    </style>
    <div class="flex items-center justify-center min-h-screen overflow-auto bg-gradient-to-r from-gray-500 bg-gray-100 dark:bg-gray-900 dark:dark:text-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="w-full lg:w-2/3">
                    <div class="bg-white shadow-lg rounded-lg mt-4 overflow-hidden">
                        <div class="px-4 py-2 bg-indigo-500 text-white text-3xl">{{ $post->content }}</div>
                        <div class="p-4 comments overflow-auto" style="max-height: 85vh;">
                            @foreach ($comments as $comment)
                                <div class="bg-gray-100 shadow mt-4 rounded">
                                    <div class="p-4">
                                        <div class="comment-content text-black text-xl font-bold" id="comment-content-{{ $comment->comment_id }}">
                                            {{ $comment->content }}
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <div class="comment-author text-black">
                                                作成者: {{ $comment->user->name }}
                                            </div>
                                            <div class="flex">
                                                @can('update', $comment)
                                                    <button type="button" onclick="editComment({{ $comment->comment_id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">修正</button>
                                                @endcan
                                                @can('delete', $comment)
                                                    <form method="POST" action="{{ route('post.comments.destroy', $comment) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">削除</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                        <form method="POST" class="comment-edit-form" id="comment-edit-form-{{ $comment->comment_id }}" action="{{ route('post.comments.update', $comment) }}" style="display: none;">
                                            @csrf
                                            @method('PUT')
                                            <textarea name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $comment->content }}</textarea>
                                            <div class="flex justify-end mt-2">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">修正</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <form method="POST" action="/post/comments" class="mt-4">
                                @csrf
                                <div class="mb-4">
                                    <textarea name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">コメント作成</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- footer --}}
    <x-footer />
</x-app-layout>