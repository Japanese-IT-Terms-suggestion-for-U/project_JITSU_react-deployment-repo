{{-- "OS", "データベース", "プログラミング" 중에서 중복으로 선택할 수 있게 레이아웃 구현 --}}
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center justify-center">
  <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center">
      
  </div>

  <div class="flex justify-between mt-4">
      <x-danger-button
              x-data=""
              x-on:click.prevent="window.modal.closeModal()"
      >{{ __('Close') }}
      </x-danger-button>
  </div>
</div>