<script>
    window.modal = {
        show: true,
        name: null,
        openModal(name) {
            this.name = name;
            if (name === '/favorite-words' || name === '/unfamiliar-words' || name === '/update-profile-information-form' || name === '/update-password-form' || name === '/delete-user-form') {
                fetch('/' + name)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        try {
                            window.initModalData(name, data);
                        } catch (error) {
                            console.log('Error occurred in initModalData: ', error);
                        }
                    })
                    .catch(error => {
                        console.log('Fetch error: ', error);
                    });
            } else {
                this.show = true;
                this.updateModal();
            }
            console.log("openModal called: ", this.show, this.name);
        },
        closeModal() {
            window.cleanupModalData();
            this.show = false;
            this.updateModal();
            this.name = null;
            console.log("closeModal called: ", this.show, this.name);
        },
        isModal(name) {
            return this.show && this.name === name;
        },
        updateModal() {
            if (this.name && this.$refs[this.name]) {
                this.$refs[this.name].style.display = this.show ? 'block' : 'none';
            }
        }
    };
    
    document.addEventListener('DOMContentLoaded', function () {
        window.initModalData = function (name, data) {
            console.log("initModalData is called for " + name);
            window[name] = data;
        };
    
        window.cleanupModalData = function () {
            console.log("cleanupModalData is called");
        };
    
        window.dispatchModalEvent = function(name, detail = {}) {
            window.dispatchEvent(new CustomEvent(name, { detail }));
        };
    
        window.addEventListener('open-modal', event => {
            window.modal.openModal(event.detail.name);
        });
    });
</script>

<div x-data="window.modal" class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
        {{ Auth::user()->name }}
    </h5>
    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
    <ul class="my-4 space-y-3">
        <li>
            <a href="#" @click.prevent="openModal('favorite-word-form')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M17.947 2.053a5.209 5.209 0 0 0-3.793-1.53A6.414 6.414 0 0 0 10 2.311 6.482 6.482 0 0 0 5.824.5a5.2 5.2 0 0 0-3.8 1.521c-1.915 1.916-2.315 5.392.625 8.333l7 7a.5.5 0 0 0 .708 0l7-7a6.6 6.6 0 0 0 2.123-4.508 5.179 5.179 0 0 0-1.533-3.793Z"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">お気に入り</span>
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="openModal('unfamiliar-word-form')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">知らない</span>
            </a>
        </li>
        {{-- TODO: 태그 설정 모달 구현 --}}
        <li>
            {{-- <a href="#" @click.prevent="$dispatch('open-modal', 'tag-setting')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white"> --}}
            <a href="#" @click.prevent="openModal('tag-setting-form')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.75 4H19M7.75 4a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 4h2.25m13.5 6H19m-2.25 0a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 10h11.25m-4.5 6H19M7.75 16a2.25 2.25 0 0 1-4.5 0m4.5 0a2.25 2.25 0 0 0-4.5 0M1 16h2.25"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">タッグの設定</span>
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="openModal('update-profile-information-form')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                    <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">プロフィール情報</span>
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="openModal('update-password-form')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                    <path d="M14 7h-1.5V4.5a4.5 4.5 0 1 0-9 0V7H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-5 8a1 1 0 1 1-2 0v-3a1 1 0 1 1 2 0v3Zm1.5-8h-5V4.5a2.5 2.5 0 1 1 5 0V7Z"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">パスワードの更新</span>
            </a>
        </li>
        <li>
            <a href="#" @click.prevent="openModal('delete-user-form')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                </svg>
                <span class="flex-1 ml-3 whitespace-nowrap">アカウント削除</span>
            </a>
        </li>
    </ul>
    <div x-ref="favorite-word-form" x-show="isModal('favorite-word-form')" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
        <div>
            @include('profile.partials.favorite-word-form')
        </div>
    </div>
    <div x-ref="unfamiliar-word-form" x-show="isModal('unfamiliar-word-form')" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
        <div>
            @include('profile.partials.unfamiliar-word-form')
        </div>
    </div>
    <div x-ref="tag-setting-form" x-show="isModal('tag-setting-form')" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
        <div>
            @include('profile.partials.tag-setting-form')
        </div>
    </div>
    <div x-ref="update-profile-information-form" x-show="isModal('update-profile-information-form')" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
        <div>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    <div x-ref="update-password-form" x-show="isModal('update-password-form')" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
        <div>
            @include('profile.partials.update-password-form')
        </div>
    </div>
    <div x-ref="delete-user-form" x-show="isModal('delete-user-form')" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
        <div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>