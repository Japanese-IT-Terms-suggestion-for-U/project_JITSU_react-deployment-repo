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

<style>
  .tag-modal-container {
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
  .tag-modal-class {
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
  .tag-checkbox-container {
      width: 50%;
      border: 2px solid #ddd;
      border-radius: 5px;
      padding: 20px;
      margin-top: 20px;
  }
  .tag-header-container {
      width: 30%;
      padding-right: 20px;
  }
  .tag-center-elements {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
  }
  .tag-button-elements {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
  }
  .tag-cursor-pointer {
      cursor: pointer;
  }
  .tag-input-field {
      padding: 10px;
      width: 100%;
      height: 50px;
      border: 1px solid #ddd;
  }
  .tag-tag-header {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 1em;
    text-align: center;
  }
</style>

<section class="tag-modal-container bg-white rounded-lg shadow">
  <header>
    <h2 class="text-lg font-medium text-white-900">
        {{ __('タッグ設定') }}
    </h2>

    <p class="mt-1 text-sm text-white-600">
        {{ __('学習したい分野を決めることができます。') }}
    </p>
  </header>

  <div class="tag-checkbox-container">
    <form id="tag-form" method="POST" action="{{ route('profile.tags.update') }}" class="tag-center-elements">
      @csrf
      @method('PATCH')

      <div class="tag-checkbox-container">
        <h3 class="tag-tag-header">Tag List</h3>
        <div class="tag-checkbox-label">
          <label class="tag-label inline-flex items-center tag-cursor-pointer">
            <input type="checkbox" id="os" name="tags[]" value="os" class="hidden">
            <span id="os-label" class="px-4 py-2 bg-blue-500 text-white rounded-lg tag-cursor-pointer">OS</span>
          </label>
          <label class="tag-label inline-flex items-center ml-6 tag-cursor-pointer">
            <input type="checkbox" id="database" name="tags[]" value="database" class="hidden">
            <span id="database-label" class="px-4 py-2 bg-blue-500 text-white rounded-lg tag-cursor-pointer">データベース</span>
          </label>
          <label class="tag-label inline-flex items-center ml-6 tag-cursor-pointer">
            <input type="checkbox" id="programming" name="tags[]" value="programming" class="hidden">
            <span id="programming-label" class="px-4 py-2 bg-blue-500 text-white rounded-lg tag-cursor-pointer">プログラミング</span>
          </label>
        </div>
      </div>
  
      <div class="tag-button-elements">
        <x-primary-button form="tag-form" type="submit">{{ __('設定完了') }}</x-primary-button>
        <x-danger-button
          x-data=""
          @click.prevent="closeModal()"
        >{{ __('Close') }}
        </x-danger-button>
      </div>
    </form>  
  </div>
</section>