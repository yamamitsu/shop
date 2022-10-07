@extends('common.layout')

@section('child')
    <p>{{ $hello }}<p>
    <div>
        <ul>
    @foreach ($hello_array as $a)
            <li>This is user {{ $a }}</li>
    @endforeach
        </ul>
    </div>
@endsection