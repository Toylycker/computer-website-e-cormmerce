@extends('layouts.app')
@section('title') @lang('app.computers') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
            <div class="h4 text-danger">@lang('app.computers')</div>
            <form action="{{ route('computers') }}">
                <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="q">
            </form>
        </div>
        <div class="row g-3">
            <div class="col-sm-4 col-md-3 col-lg-2">
                @include('app.filter')
            </div>
            <div class="col-sm">
                @if($computers->count() > 0)
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                    @foreach($computers as $computer)
                        <div class="col">
                            @include('app.computer')
                        </div>
                    @endforeach
                </div>
                <div class="my-3">
                    {{ $computers->links() }}
                </div>
                @else
                    <div class="p-5 h2 mb-0 text-center">
                        @lang('app.not-found', ['name' => 'Product'])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection