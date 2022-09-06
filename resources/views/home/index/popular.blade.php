<div class="container-xxl py-3">
    <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
        <span class="d-block h4 mb-0 text-danger">@lang('app.populars')</span>
        <span class="d-block"><i class="bi bi-chevron-right"></i></span>
    </div>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
        @foreach($popular as $computer)
            <div class="col">
                @include('app.computer')
            </div>
        @endforeach
    </div>
</div>