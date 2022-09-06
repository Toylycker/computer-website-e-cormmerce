@extends('layouts.app')
@section('title') @lang('app.register') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger text-center border-bottom py-2 mb-3">
            @lang('app.register')
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-6 col-lg-4">
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">@lang('app.name')</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" autofocus>
                        @error('name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">@lang('app.username')</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" autocomplete="off" aria-describedby="usernameHelp">
                        @error('username')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                        <div id="usernameHelp" class="form-text">We'll never share your username with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('app.password')</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                        @error('password')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">@lang('app.password-confirmation')</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                        @error('password_confirmation')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> @lang('app.register')
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection