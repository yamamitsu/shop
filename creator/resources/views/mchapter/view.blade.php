@extends('common.layout')

@php
$entryCount = 0;
@endphp
@section('child')
  <h2>BCP入力欄</h2>
  <article>
    {{ $chapter->title }}(章ID:{{$chapter->chapter_id}})
    <form url="mchapter/confirm/{{$chapter->chapter_id}}" method="POST">
    @foreach ($questions as $q)
      <div class="row">
        <div class="col-1"></div>
        <section class="col-10">
          <h3 id="question{{ $chapter->chapter_id }}_{{ $q->question_id }}">{{ $q->question_id }}: {{ $q->content }}</h3>
          @php
            $branches = $q->branches()->get();
          @endphp
          @if ($branches)
            @foreach ($branches as $b)
              <section>
                <template id="default_{{$entryCount}}">{{ $b->content }}</template>
                <input type="hidden" name="entries[{{ $entryCount }}][question_id]" value="{{ $q->question_id }}" />
                <input type="hidden" name="entries[{{ $entryCount }}][branch_id]" value="{{ $b->branch_id }}" />
                <textarea id="entry_{{$entryCount}}" class="form-control col-12 bg-primary bg-opacity-10" name="entries[{{ $entryCount }}][entry]">{{ $b->content }}</textarea>
                <button id="btn_reset_entry_{{$entryCount}}" class="btn btn-light float-end" style="margin-top: 5px;" onclick="resetText({{$entryCount}})" type="button">元に戻す</button>
              </section>
              @php
                $entryCount++;
              @endphp
            @endforeach
          @endif
        </section>
        <div class="col-1"></div>
      </div>
    @endforeach
    <div class="row">
      <div class="col-1"></div>
      <div class="col-2">
        <button class="btn btn-primary" type="submit" value="">保存</button>
      </div>
      <div class="col-9"></div>
    </div>
</form>
  </article>
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", () => {
      // textareaタグを全て取得
      const textareaEls = document.querySelectorAll("textarea");

      textareaEls.forEach((textareaEl) => {
        // デフォルト値としてスタイル属性を付与
        textareaEl.setAttribute("style", `height: ${textareaEl.scrollHeight+20}px;`)
        // inputイベントが発生するたびに関数呼び出し
        textareaEl.addEventListener("input", setTextareaHeight)
      })

      // textareaの高さを計算して指定する関数
      function setTextareaHeight() {
        this.style.height = "auto"
        this.style.height = `${this.scrollHeight+20}px`
        const btn = document.getElementById('btn_reset_'+this.id)
        if (btn) {
          btn.classList.remove('btn-light')
          btn.classList.add('btn-info')
        }
      }
    });

    function resetText(entryCount) {
      const template = document.getElementById('default_'+entryCount)
      const textarea = document.getElementById('entry_'+entryCount)
      textarea.value = template.innerHTML
      const btn = document.getElementById('btn_reset_entry_'+entryCount)
      if (btn) {
          btn.classList.remove('btn-info')
          btn.classList.add('btn-light')
        }
    }
  </script>
@endsection
