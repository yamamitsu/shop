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
          @if (!$c->parent_id) {{-- 各章 --}}{{-- 各章内の節項目 --}}
            <li>{{ $c->pivot->idx }} <a href="/bcpform/{{ $c->chapter_id }}">{{ $c->title }}</a></li>
          @elseif (isset($questions[$c->chapter_id]))
            <li>{{ $c->pivot->idx }} <a href="/bcpform/{{ $c->parent_id }}#subchapter_{{ $questions[$c->chapter_id] }}">{{ $c->title }}</a></li>
          @else
            <li>{{ $c->pivot->idx }} {{ $c->title }}</li>
          @endif
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
