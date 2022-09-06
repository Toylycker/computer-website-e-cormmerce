@extends('layouts.app')
@section('title') {{ $computer->name }} @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
            <div class="h4 text-danger">{{ $computer->name }}</div>
            @auth
                <div>
                    <a href="{{ route('computer.edit', $computer->slug) }}" class="btn btn-success btn-sm text-decoration-none">
                        <i class="bi bi-pencil-fill"></i> @lang('app.edit')
                    </a>
                    <button type="button" class="btn btn-secondary btn-sm text-decoration-none" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash-fill"></i> @lang('app.delete')
                    </button>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @lang('app.delete-question', ['name' => $computer->name])
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('computer.delete', $computer->slug) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('app.cancel')</button>
                                        <button type="submit" class="btn btn-secondary">@lang('app.delete')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-4">
                <div class="position-relative d-flex justify-content-center align-items-center">
                    <img src="{{ $computer->image() }}" alt="" class="img-fluid border rounded">
                    @if($computer->isDiscount())
                        <div class="position-absolute text-light fw-bold bg-danger bg-opacity-75 rounded end-0 top-0 px-1 m-1">
                            -{{ $computer->discount_percent }}%
                        </div>
                    @endif
                    @if($computer->isNew())
                        <div class="position-absolute text-light fw-bold bg-warning bg-opacity-75 rounded start-0 top-0 px-1 m-1">
                            @lang('app.new')
                        </div>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="d-block h2 fw-bold mb-3">
                    {{ $computer->name }}
                </div>
                <a href="{{ route('computers', ['b' => [$computer->brand_id]]) }}" class="d-block h5 fw-bold link-secondary mb-3">
                    {{ $computer->brand->name }}
                </a>
                <a href="{{ route('computers', ['c' => [$computer->category_id]]) }}" class="d-block h5 fw-bold link-secondary mb-3">
                    {{ $computer->category->name() }}
                </a>
                <div class="d-block h5 fw-bold mb-3">
                    <span class="text-secondary">@lang('app.model-number'):</span> {{ $computer->model_number }}
                </div>
                <div class="d-block h5 fw-bold mb-3">
                    <span class="text-secondary">@lang('app.serial-number'):</span> {{ $computer->serial_number }}
                </div>
                <div class="h5 fw-bold mb-3">
                    @if($computer->isDiscount())
                        <span class="text-secondary"><s>{{ number_format($computer->price, 2, ".", " ") }}</s></span>
                        <span class="text-danger">{{ number_format($computer->price(), 2, ".", " ") }} <small>TMT</small></span>
                    @else
                        <span class="text-primary">{{ number_format($computer->price, 2, ".", " ") }} <small>TMT</small></span>
                    @endif
                    @if($computer->credit)
                        <i class="bi bi-patch-check-fill text-info"></i>
                    @endif
                </div>
                <div class="d-flex align-items-center fw-bold mb-3">
                    <div class="me-4">
                        <i class="bi bi-basket-fill text-black-50"></i> {{ $computer->sold }}
                    </div>
                    <div class="me-4">
                        <i class="bi bi-binoculars-fill text-black-50"></i> {{ $computer->viewed }}
                    </div>
                    <a href="{{ route('computer.favorite', $computer->slug) }}" class="btn btn-danger btn-sm text-decoration-none">
                        <i class="bi bi-heart-fill"></i> {{ $computer->favorited }}
                    </a>
                </div>
                @if($computer->description)
                    <div class="mb-3">
                        {!! $computer->description !!}
                    </div>
                @endif
                @foreach($computer->values as $value)
                    <div class="{{ $loop->last ? 'mb-3':'mb-2' }}">
                        <span class="text-secondary">{{ $value->option->name }}:</span>
                        <a href="{{ route('computers', ['v' => [[$value->id]]]) }}" class="link-dark">{{ $value->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="my-3">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-3">
                @foreach($similar as $computer)
                    <div class="col">
                        @include('app.computer')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection