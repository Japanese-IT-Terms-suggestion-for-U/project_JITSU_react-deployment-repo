<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    // 레이블 클릭 시 체크박스 선택 토글
    document.querySelectorAll('#tag-form span').forEach((label) => {
      label.addEventListener('click', (event) => {
        const checkbox = document.querySelector(`#${label.id.replace('-label', '')}`);
        checkbox.checked = !checkbox.checked;

        // 체크박스의 선택 여부에 따라 배경색 변경
        if (checkbox.checked) {
          label.classList.remove('bg-blue-500');
          label.classList.add('bg-green-500');
        } else {
          label.classList.add('bg-blue-500');
          label.classList.remove('bg-green-500');
        }

        // 폼 데이터 갱신
        checkbox.dispatchEvent(new Event('change', {bubbles: true}));
        event.preventDefault(); // 이벤트 전파 중단
      });
    });

    // 사용자가 선택한 태그에 해당하는 체크박스 선택 및 레이블 배경색 변경
    fetch('{{ route('profile.tags.get') }}')
      .then(response => response.json())
      .then(tags => {
        console.log(tags);
        tags.forEach((tagName) => {
          // 체크박스 ID 형식으로 태그 이름 변환
          const tagId = tagName.toLowerCase().replace(' ', '-');

          const checkbox = document.querySelector(`#${tagId}`);
          const label = document.querySelector(`#${tagId}-label`);
          if (checkbox && label) {
            checkbox.checked = true;
            label.classList.remove('bg-blue-500');
            label.classList.add('bg-green-500');
          }
        });
      });
  });
</script>

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center justify-center">
  <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center justify-center">
    <form id="tag-form" method="POST" action="{{ route('profile.tags.update') }}">
      @csrf
      @method('PATCH')
  
      <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center">
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" id="os" name="tags[]" value="os" class="hidden">
            <span id="os-label" class="px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer">OS</span>
          </label>
          <label class="inline-flex items-center ml-6">
            <input type="checkbox" id="database" name="tags[]" value="database" class="hidden">
            <span id="database-label" class="px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer">データベース</span>
          </label>
          <label class="inline-flex items-center ml-6">
            <input type="checkbox" id="programming" name="tags[]" value="programming" class="hidden">
            <span id="programming-label" class="px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer">プログラミング</span>
          </label>
        </div>
      </div>
  
      <div class="flex justify-between mt-4">
        <x-danger-button
          x-data=""
          @click.prevent="closeModal()"
        >{{ __('Close') }}
        </x-danger-button>
        <x-primary-button form="tag-form" type="submit">{{ __('設定完了') }}</x-primary-button>
      </div>
    </form>
  </div>  
</div>