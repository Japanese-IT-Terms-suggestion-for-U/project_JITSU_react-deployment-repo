<style>
    .password-update-modal-container {
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
    .password-update-modal-class {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-between;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 0 auto;
        width: 800px;
        height: 600px;
    }
    .password-update-form-container {
        width: 25%;
        border: 2px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-top: 20px;
    }
    .password-update-header-container {
        width: 30%;
        padding-right: 20px;
    }
    .password-update-center-elements {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .password-update-button-elements {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
    .password-update-cursor-pointer {
        cursor: pointer;
    }
    .password-update-input-field {
        padding: 10px;
        width: 100%;
        height: 50px;
        border: 1px solid #ddd;
    }
</style>

<section class="password-update-modal-container bg-white rounded-lg shadow">
    <header class="password-update-header-container">
        <h2 class="text-lg font-medium text-white-900">
            {{ __('パスワードの更新') }}
        </h2>

        <p class="mt-1 text-sm text-white-600">
            {{ __('アカウントの安全性を保つために、長くてランダムなパスワードを使用していることを確認してください。') }}
        </p>
    </header>

    <div class="password-update-form-container">
        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 password-update-center-elements">
            @csrf
            @method('put')
    
            <div>
                <x-input-label for="current_password" :value="__('現在のパスワード')" />
                <x-text-input id="current_password" name="current_password" type="password" class="password-update-input-field mt-1 block w-full" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
    
            <div>
                <x-input-label for="password" :value="__('新しいパスワード')" />
                <x-text-input id="password" name="password" type="password" class="password-update-input-field mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
    
            <div>
                <x-input-label for="password_confirmation" :value="__('パスワード確認')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="password-update-input-field mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
    
            <div class="flex items-center gap-4 password-update-button-elements">
                <x-primary-button>{{ __('更新') }}</x-primary-button>
                <x-danger-button
                    x-data=""
                    @click.prevent="closeModal()"
                >{{ __('Close') }}
                </x-danger-button>
    
                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('パスワードを更新しました。') }}</p>
                @endif
            </div>
        </form>
    </div>
</section>
