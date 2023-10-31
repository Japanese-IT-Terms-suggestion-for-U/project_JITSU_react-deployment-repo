<header class="sm:fixed sm:top-0 w-full flex justify-between items-center p-6 z-10">
  {{-- Logo --}}
  <div class="mx-auto sm:mx-0">
    <img src="/images/logo.png" alt="logo" class="w-16 h-16">
  </div>

  {{-- Right Side Of Navbar --}}
  @if (Route::has('login'))
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
        @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ダッシュボード</a>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">ログイン</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">会員登録</a>
            @endif
        @endauth
    </div>
  @endif
</header>