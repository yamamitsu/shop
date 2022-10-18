@extends('common.layout')

@php
$entryCount = 0;
@endphp
@section('child')
  <h2>BCP入力欄</h2>
  <article>
    {{ $chapter->title }}(章ID:{{$chapter->chapter_id}})
    <form action="/bcpform/confirm/{{$chapter->chapter_id}}" method="POST">
    @csrf
    @foreach ($questions as $q)
    
      @if ($q->mode == 1) {{-- 通常設問 --}}
      @endif
      
      @if ($q->mode == 2) {{-- 画像アップロード --}}
      @endif
      
      <div class="row">
        <div class="col-1"></div>
        <section class="col-10">
          @if ($q->parent_id) {{-- サブ設問 --}}
            <h4 id="question{{ $chapter->chapter_id }}_{{ $q->question_id }}">{{ $q->caption }}</h4>
          @else {{-- メイン設問 --}}
            <h3 id="question{{ $chapter->chapter_id }}_{{ $q->question_id }}">{{ $q->question_id }}: {{ $q->caption }}</h3>
          @endif
          @if ($q->subtext)
            <p >{{ $q->subtext }}</p>
          @endif
          @if ($q->branches)
            @foreach ($q->branches as $b)
              <section>
                <template id="default_{{$entryCount}}">{{ $b->content }}</template>
                <input type="hidden" name="entries[{{ $entryCount }}][question_id]" value="{{ $q->question_id }}" />
                <input type="hidden" name="entries[{{ $entryCount }}][branch_id]" value="{{ $b->branch_id }}" />
                @if (count($entries) > 1)
                  <input type="hidden" name="entries[{{ $entryCount }}][entry_id]" value="{{ $entries[$b->branch_id]->entry_id }}" />
                  <textarea id="entry_{{$entryCount}}" class="form-control col-12 bg-primary bg-opacity-10" name="entries[{{ $entryCount }}][content]">{{ $entries[$b->branch_id]->content }}</textarea>
                @else {{-- entriesが入力されていない場合はマスターの初期値をそのまま出す --}}
                  <textarea id="entry_{{$entryCount}}" class="form-control col-12 bg-primary bg-opacity-10" name="entries[{{ $entryCount }}][content]">{{ $b->content }}</textarea>
                @endif
                <button id="btn_reset_entry_{{$entryCount}}" class="btn btn-light float-end" style="margin-top: 5px;" onclick="resetText({{$entryCount}})" type="button">元に戻す</button>
              </section>
              @php
                $entryCount++;
              @endphp
            @endforeach
            @if ($q->mode == 3) {{-- 項目を増減できる設問 --}}
              @if ($entries[0]) {{-- 追加入力された項目の出力 --}}
                @foreach ($entries[0] as $e)
                  <section>
                    <input type="hidden" name="entries[{{ $entryCount }}][question_id]" value="{{ $q->question_id }}" />
                    <input type="hidden" name="entries[{{ $entryCount }}][entry_id]" value="{{ $e->entry_id }}" />
                    <input type="hidden" name="entries[{{ $entryCount }}][additional]" value="1" />
                    <textarea id="entry_{{$entryCount}}" class="form-control col-12 bg-primary bg-opacity-10" name="entries[{{ $entryCount }}][content]">{{ $e->content }}</textarea>
                    <input id="entry_chedk_{{$entryCount}}"  type="checkbox" style="margin-top: 5px;" onclick="checkAdditional({{$entryCount}})" name="entries[{{ $entryCount }}][deleted]" value="1">
                    <label for="entry_chedk_{{$entryCount}}">削除する</label>
                    @php
                      $entryCount++;
                    @endphp
                  </section>
                @endforeach
              @endif
              <section> {{-- 新規追加用の入力欄 --}}
                <input type="hidden" name="entries[{{ $entryCount }}][question_id]" value="{{ $q->question_id }}" />
                <input type="hidden" name="entries[{{ $entryCount }}][additional]" />
                <textarea id="entry_{{$entryCount}}" class="form-control col-12 bg-primary bg-opacity-10" name="entries[{{ $entryCount }}][content]"></textarea>
                <button id="btn_add_entry_{{$entryCount}}" class="btn btn-light float-end" style="margin-top: 5px;" onclick="resetText({{$entryCount}})" type="button">追加する</button>
                @php
                  $entryCount++;
                @endphp
              </section>
            @endif      
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
