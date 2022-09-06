@extends('layouts.app')
@section('title') @lang('app.contact') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger border-bottom py-2 mb-3">
            @lang('app.contact')
        </div>
        <div>
            {!! $page->body !!}
        </div>
    </div>
@endsection