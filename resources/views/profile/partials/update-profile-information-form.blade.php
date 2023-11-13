<style>
    button {
        transition: transform 0.1s ease;
    }
    button:active {
        transform: scale(0.95);
    }
    .update-profile-modal-container {
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
    .update-profile-modal-class {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 0 auto;
        width: 800px;
        height: 600px;
    }
    .update-profile-form-container {
        width: 100%;
        border: 2px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-top: 20px;
    }
    .update-profile-center-elements {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .update-profile-button-elements {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
    .update-profile-cursor-pointer {
        cursor: pointer;
    }
    .update-profile-input-field {
        padding: 10px;
        width: 100%;
        height: 50px;
    }
</style>

<section class="update-profile-modal-container bg-white rounded-lg shadow">
    <header>
        <h2 class="text-lg font-medium text-white-900">
            {{ __('プロフィール情報') }}
        </h2>

        <p class="mt-1 text-sm text-white-600">
            {{ __("アカウントのプロフィール情報とEメールアドレスを更新します。") }}
        </p>
    </header>

    <div class="">
        <div class="update-profile-modal-class">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <div class="update-profile-form-container">
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 center-elements">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('お名前')" />
                        <x-text-input id="name" name="name" type="text" class="update-profile-input-field mt-1 block w-full" :value="old('name', Auth::user()->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('メール')" />
                        <x-text-input id="email" name="email" type="email" class="update-profile-input-field mt-1 block w-full" :value="old('email', Auth::user()->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('更新') }}</x-primary-button>
                        <x-danger-button
                            x-data=""
                            @click.prevent="closeModal()"
                        >{{ __('Close') }}
                        </x-danger-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('情報を更新しました。') }}</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
