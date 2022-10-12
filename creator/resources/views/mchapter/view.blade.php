@extends('common.layout')

@php
$entryCount = 0;
@endphp
@section('child')
  <h2>BCP入力欄</h2>
  <article>
    入力欄:(章ID: {{ $chapter_id }})
    @foreach ($questions as $q)
      <div class="row">
        <div class="col-1"></div>
        <section class="col-10">
          <h3 id="question{{ $chapter_id }}_{{ $q->question_id }}">{{ $q->question_id }}: {{ $q->content }}</h3>
          @php
            $branches = $q->branches()->get();
          @endphp
          @if ($branches)
            @foreach ($branches as $b)
              <section>
                <template id="default_{{$entryCount}}">{{ $b->content }}</template>
                <input type="hidden" name="entries[{{ $entryCount }}][question_id]" value="{{ $q->question_id }}" />
                <input type="hidden" name="entries[{{ $entryCount }}][branch_id]" value="{{ $b->branch_id }}" />
                <textarea id="entry_{{$entryCount}}" class="col-12" name="entries[{{ $entryCount }}][entry]">{{ $b->content }}</textarea>
                <button onclick="resetText({{$entryCount}})">元に戻す</button>
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
  </article>
  <script type="text/javascript">
    function resetText(entryCount) {
      const template = document.getElementById('default_'+entryCount)
      const textarea = document.getElementById('entry_'+entryCount)
      textarea.value = template.innerHTML
    }
  </script>
@endsection
