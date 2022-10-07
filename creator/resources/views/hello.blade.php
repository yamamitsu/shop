@extends('common.layout')

@section('child')
<p>{{ $hello }}<p>
<p>kkk {{ $aaa }}<p>
    <div>
        <ul>
    @foreach ($hello_array as $a)
            <li>This is user {{ $a }}</li>
    @endforeach
        </ul>
    </div>
@endsection