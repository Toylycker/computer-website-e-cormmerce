@extends('layouts.app')
@section('title') @lang('app.app-description') @endsection
@section('content')
    @if($discount->count() > 0)
        @include('home.index.discount')
    @endif
    @if($new->count() > 0)
        @include('home.index.new')
    @endif
    @if($recommend->count() > 0)
        @include('home.index.recommend')
    @endif
    @if($credit->count() > 0)
        @include('home.index.credit')
    @endif
    @if($popular->count() > 0)
        @include('home.index.popular')
    @endif
@endsection