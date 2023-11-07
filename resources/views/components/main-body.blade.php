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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <h1 class="text-3xl font-bold mb-4">🏯 JITSU</h1>
                <p class="mb-4">Japanese It Terms suggestion for U</p>

                <h2 class="text-2xl font-bold mt-4 mb-2">1. サービス紹介</h2>
                <p class="mb-4">このページは'勉強したい分野の単語を学習できるようにランダムで出せるサービス、JITSU'に関する全体的な情報を提供します。ユーザーの傾向に合った単語を学習することができます。</p>

                <h2 class="text-2xl font-bold mt-4 mb-2">2. 気にしていたとこ</h2>
                - SSR <br>
                - Crawling <br>
                - Pipeline <br>

                <h2 class="text-2xl font-bold mt-4 mb-2">3. 機能</h2>
                - ログイン・会員登録 <br>
                - マイページ <br>
                - 単語カード <br>

                <h2 class="text-2xl font-bold mt-4 mb-2">4. プロジェクト構造</h2>

                <h2 class="text-2xl font-bold mt-4 mb-2">5. 技術スタック</h2>
                <!-- 기술 스택 이미지 추가 -->
                <!-- 커뮤니케이션 도구 이미지 추가 -->
            </div>
        </div>
    </body>
</html>
