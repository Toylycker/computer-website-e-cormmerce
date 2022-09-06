@extends('layouts.app')
@section('title') {{ $computer->name }} - @lang('app.edit') @endsection
@section('content')
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger text-center border-bottom py-2 mb-3">
            {{ $computer->name }} - @lang('app.edit')
        </div>
        <div class="row justify-content-center">
            <form action="{{ route('computer.update', $computer->slug) }}" method="post" enctype="multipart/form-data" class="col-md-6 col-lg-4">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">
                        @lang('app.category') <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required autofocus>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $computer->category_id ? 'selected':'' }}>
                                {{ $category->name() }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="brand_id" class="form-label fw-bold">
                        @lang('app.brand') <span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id" required>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $computer->brand_id ? 'selected':'' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="model_number" class="form-label fw-bold">
                        @lang('app.model-number') <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('model_number') is-invalid @enderror" name="model_number" id="model_number" value="{{ $computer->model_number }}" maxlength="255" required>
                    @error('model_number')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="serial_number" class="form-label fw-bold">
                        @lang('app.serial-number') <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('serial_number') is-invalid @enderror" name="serial_number" id="serial_number" value="{{ $computer->serial_number }}" maxlength="255" required>
                    @error('serial_number')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">
                        @lang('app.description')
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" maxlength="2550">{{ $computer->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">
                        @lang('app.price') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ $computer->price }}" min="0" step="0.1" required>
                    @error('price')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label fw-bold">
                        @lang('app.stock') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" value="{{ $computer->stock }}" min="0" required>
                    @error('stock')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_percent" class="form-label fw-bold">
                        @lang('app.discount-percent') <span class="text-danger">*</span>
                    </label>
                    <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" name="discount_percent" id="discount_percent" value="{{ $computer->discount_percent }}" min="0" required>
                    @error('discount_percent')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_datetime_start" class="form-label fw-bold">
                        @lang('app.discount-datetime-start') <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" class="form-control @error('discount_datetime_start') is-invalid @enderror" name="discount_datetime_start" id="discount_datetime_start" value="{{ $computer->discount_datetime_start->format('Y-m-d\TH:i') }}" required>
                    @error('discount_datetime_start')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="discount_datetime_end" class="form-label fw-bold">
                        @lang('app.discount-datetime-end') <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" class="form-control @error('discount_datetime_end') is-invalid @enderror" name="discount_datetime_end" id="discount_datetime_end" value="{{ $computer->discount_datetime_end->format('Y-m-d\TH:i') }}" required>
                    @error('discount_datetime_end')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @foreach($options as $option)
                    <div class="mb-3">
                        <label for="option_{{ $option->id }}" class="form-label fw-bold">
                            {{ $option->name }} <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('values_id') is-invalid @enderror" id="option_{{ $option->id }}" name="values_id[]" required>
                            @foreach($option->values as $value)
                                <option value="{{ $value->id }}" {{ $computer->values->contains($value->id) ? 'selected':'' }}>
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('values_id')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                @endforeach

                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">@lang('app.image') (500x500)</label>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/jpeg">
                    @error('image')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="credit" id="credit" value="1" {{ $computer->credit ? 'checked':'' }}>
                        <label class="form-check-label" for="credit">
                            @lang('app.credit')
                        </label>
                        @error('credit')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="recommend" id="recommend" value="1" {{ $computer->recommend ? 'checked':'' }}>
                        <label class="form-check-label" for="recommend">
                            @lang('app.recommend')
                        </label>
                        @error('recommend')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2-circle"></i> @lang('app.update')
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection