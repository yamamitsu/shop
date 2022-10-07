@extends('common.layout')

@section('child')
    <p>mchapter表示したい内容<p>
    <div>
        <ul>
    @foreach ($hello_array as $a)
            <li>This is user {{ $a }}</li>
    @endforeach
        </ul>
        <div>mchapter:
            <ul>
                <li>version:{{$m->version}}</li>
                <li>title:{{$m->title}}</li>
            </ul>
        </div>
    </div>
@endsection