@extends('layouts.app')
@section('title') @lang('app.about-us') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger border-bottom py-2 mb-3">
            @lang('app.about-us')
        </div>
        <div>
            {!! $page->body !!}
        </div>
    </div>
@endsection