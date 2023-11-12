<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-r from-gray-500 bg-gray-100 dark:bg-gray-900 dark:dark:text-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 text-white pb-20">
            <div class="w-2/5 sm:max-w-full mt-6 px-2 sm:px-4 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg text-gray-800"> <!-- 너비와 패딩 수정 -->
                <h1 class="text-4xl font-bold mb-4 text-center text-purple-600 transform transition-all hover:scale-125 animate-bounce">🏯 JITSU</h1>
                <p class="mb-4 text-gray-600 text-center animate-pulse">Japanese IT Terms suggestion for U</p>

                <div class="my-6 p-4 bg-blue-100 rounded-xl shadow-2xl hover:bg-blue-200 transition-all duration-500">
                    <h2 class="text-2xl font-bold mb-2 bg-blue-300 p-2 rounded text-white shadow-lg animate-wiggle">サービス紹介</h2>
                    <p class="mb-4 text-gray-700 animate-pulse">このページは'勉強したい分野の単語を学習できるようにランダムで出せるサービス、JITSU'に関する全体的な情報を提供します。ユーザーの傾向に合った単語を学習することができます。</p>
                </div>

                <div class="my-6 p-4 bg-blue-100 rounded-xl shadow-2xl hover:bg-blue-200 transition-all duration-500">
                    <h2 class="text-2xl font-bold mb-2 bg-blue-300 p-2 rounded text-white shadow-lg animate-wiggle">気にしていたとこ</h2>
                    <ul class="space-y-2">
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">SSR</li>
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">Crawling</li>
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">Pipeline</li>
                    </ul>
                </div>

                <div class="my-6 p-4 bg-blue-100 rounded-xl shadow-2xl hover:bg-blue-200 transition-all duration-500">
                    <h2 class="text-2xl font-bold mb-2 bg-blue-300 p-2 rounded text-white shadow-lg animate-wiggle">機能</h2>
                    <ul class="space-y-2">
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">ログイン</li>
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">マイページ</li>
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">用語カード</li>
                        <li class="p-3 bg-gray-200 rounded shadow animate-pulse">コミュニティー</li>
                    </ul>
                </div>

                <div class="my-6 p-4 bg-blue-100 rounded-xl shadow-2xl hover:bg-blue-200 transition-all duration-500">
                    <h2 class="text-2xl font-bold mb-2 bg-blue-300 p-2 rounded text-white shadow-lg animate-wiggle">技術スタック</h2>
                    <div class="flex justify-around mt-4">
                        <img src="{{ asset('images/laravel.svg') }}" alt="Laravel" class="w-12 h-12 animate-bounce">
                        <img src="{{ asset('images/mysql.svg') }}" alt="MySQL" class="w-12 h-12 animate-bounce">
                        <img src="{{ asset('images/tailwind.svg') }}" alt="Tailwind CSS" class="w-12 h-12 animate-bounce">
                        <img src="{{ asset('images/python.svg') }}" alt="Python" class="w-12 h-12 animate-bounce">
                        <img src="{{ asset('images/github.svg') }}" alt="Github" class="w-12 h-12 animate-bounce">
                        <img src="{{ asset('images/devops.svg') }}" alt="DevOps" class="w-12 h-12 animate-bounce">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
