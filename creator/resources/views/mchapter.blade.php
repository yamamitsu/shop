@extends('common.layout')

@section('child')
    <p>mchapter表示したい内容<p>
    <div>
        <ul>
    @foreach ($hello_array as $a)
            <li>This is user {{ $a }}</li>
    @endforeach
        </ul>
        <div>目次:
            <ul>
        @php
            $parent_id = null;
        @endphp
        @foreach ($chapters as $c)
            @if (!is_null($c->parent_id) && is_null($parent_id))
                <ul>
            @endif
            @if (is_null($c->parent_id) && !is_null($parent_id))
                </ul>
            @endif
                <li>{{$c->pivot->idx}} <a href="/mchapter/{{$c->chapter_id}}">{{$c->title}}</a></li>
            @php
                $parent_id = $c->parent_id;
            @endphp
        @endforeach
        @if (!is_null($parent_id))
                </ul>
        @endif
            </ul>
        </div>
    </div>
@endsection