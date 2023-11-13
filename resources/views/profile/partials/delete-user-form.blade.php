<style>
    button {
        transition: transform 0.1s ease;
    }
    button:active {
        transform: scale(0.95);
    }
    .delete-user-modal-container {
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
    .delete-user-modal-class {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin: 0 auto;
        /* width: 800px; */
        /* height: 600px; */
        border: 2px solid #ddd;
    }
    .delete-user-header-container {
        width: 100%;
        padding-bottom: 20px;
    }
    .delete-user-center-elements {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .delete-user-button-elements {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
    .delete-user-cursor-pointer {
        cursor: pointer;
    }
</style>

<section class="delete-user-modal-container">
    <div class="delete-user-modal-class rounded-lg shadow">
        <header class="delete-user-header-container">
            <h2 class="text-lg font-medium text-white-900">
                {{ __('アカウント削除') }}
            </h2>

            <p class="mt-1 text-sm text-white-600">
                {{ __('アカウントが削除されると、そのリソースとデータはすべて永久に削除されます。アカウントを削除する前に、保持したいデータや情報をダウンロードしてください。') }}
            </p>
        </header>

        <div class="delete-user-button-elements">
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >{{ __('削除') }}</x-danger-button>

            <x-danger-button
                x-data=""
                @click.prevent="closeModal()"
            >{{ __('Close') }}
            </x-danger-button>
        </div>

        <div class="delete-user-form-container">
            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')
    
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('本当にアカウントを削除しますか？') }}
                    </h2>
    
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('アカウントが削除されると、そのリソースとデータはすべて永久に削除されます。パスワードを入力して、アカウントの永久削除を希望することを確認してください。') }}
                    </p>
    
                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
    
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="{{ __('Password') }}"
                        />
    
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
    
                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('キャンセル') }}
                        </x-secondary-button>
    
                        <x-danger-button class="ml-3">
                            {{ __('アカウント削除') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</section>
