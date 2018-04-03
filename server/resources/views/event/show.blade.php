@extends('layout.generic')

@section('content')

    <pre>{{ $eventJson }}</pre>

    <a href="{{ Request::url() }}?position={{ intval(Request::get('position')) - 1 }}">Next</a>
    <a href="{{ Request::url() }}?position={{ intval(Request::get('position')) + 1 }}">Next</a>

@endsection