<div class="container-xxl py-3">
    <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
        <a href="{{ route('computers', ['c' => 1]) }}" class="d-block h4 mb-0 link-danger">@lang('app.credits')</a>
        <a href="{{ route('computers', ['c' => 1]) }}" class="d-block"><i class="bi bi-chevron-right"></i></a>
    </div>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
        @foreach($credit as $computer)
            <div class="col">
                @include('app.computer')
            </div>
        @endforeach
    </div>
</div>