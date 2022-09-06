@extends('layouts.app')
@section('content')
        @if($computers->count() > 0)

            @foreach($computers as $computer)




            <div class="container-sm py-3">
                <div class="d-flex justify-content-between align-items-center border-bottom py-2 mb-3">
                    <a href="{{ route('computer', $computer->slug) }}" class="position-relative d-flex justify-content-start align-items-center">
                        <div class="h4 text-danger">{{ $computer->name }}</div>
                    </a>
                </div>
                <div class="row g-3">
                    <div class="col-lg-2 col-sm-4 col-md-4">
                        <div class="position-relative d-flex justify-content-center align-items-center">
                            <a href="{{ route('computer', $computer->slug) }}" class="position-relative d-flex justify-content-center align-items-center">
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
                            </a>
                        </div>
                    </div>


                    <div class="col-9 col-sm-7 col-md-7">
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
                                <div class="d-none">
                                    {{$total_price += $computer->price()}}
                                </div>
                            @else
                                <span class="text-primary">{{ number_format($computer->price, 2, ".", " ") }} <small>TMT</small></span>
                                <div class="d-none">
                                    {{$total_price += $computer->price}}
                                </div>
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
                    </div>

                    <div class="col-1">
                        <a href="{{ route('computer.busket', $computer->slug) }}">
                            @if (!in_array($computer->id, $busket))
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success"><i class="bi bi-plus-square-fill"></i></button>
                                </div>
                            @elseif(in_array($computer->id, $busket))
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-lg btn-danger"><i class="bi bi-dash-square"></i></button>
                                </div>
                            @endif
                        </a>
                    </div>

                </div>
            </div>
            @endforeach
            <div class="my-3">
                {{ $computers->links() }}
            </div>


            <div class="input-group container-lg my-3">
                <span class="input-group-text">Jemi:</span>
                <input type="text" class="form-control" value='{{ number_format($total_price, 2, ".", " ") }}' aria-label="Dollar amount (with dot and two decimal places)">
                <span class="input-group-text">TMT</span>
            </div>

            <div class="container-lg my-3">
                <form action='{{route('home')}}' method='POST'>
                    @csrf
                    <div class="mb-3">
                    <label for="name" class="form-label">adynyz</label>
                    <input type="text" class="form-control" id="name" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                    <label for="address" class="form-label">yashayan yeriniz</label>
                    <input type="text" class="form-control" id="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">telefon belginiz</label>
                        <input type="numeric" class="form-control" id="phone">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">goshmaca maglumat</span>
                        <textarea class="form-control" aria-label="With textarea"></textarea>
                    </div>
                            <button type="submit" class="btn btn-primary">ugrat</button>
                </form>
            </div>


        @else
            <div class="p-5 h2 mb-0 text-center">
                @lang('app.not-found', ['name' => 'Product'])
            </div>
        @endif




@endsection