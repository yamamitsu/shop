@extends('common.layout')

@php
  $parent_id = null;
@endphp
@section('child')
  <h2>BCP入力欄</h2>
  <article class="row">
    <div class="col-1"></div>
    <section class="col-10">目次:
      <ul>
        @foreach ($chapters as $c)
          @if (!is_null($c->parent_id) && is_null($parent_id))
            <ul>
          @endif
          @if (is_null($c->parent_id) && !is_null($parent_id))
            </ul>
          @endif
          <li>{{ $c->pivot->idx }} <a href="/bcpform/{{ $c->chapter_id }}">{{ $c->title }}</a></li>
          @php
            $parent_id = $c->parent_id;
          @endphp
        @endforeach
      @if (!is_null($parent_id))
        </ul>
      @endif
      </ul>
    </section>
    <div class="col-1"></div>
  </article>
@endsection
