<form action="{{ url()->current() }}" method="get">
    <div class="accordion" id="accordionPanelsStayOpenExample">

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading-c">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-c" aria-expanded="true" aria-controls="panelsStayOpen-collapse-c">
                    @lang('app.categories')
                </button>
            </h2>
            <div id="panelsStayOpen-collapse-c" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading-c">
                <div class="accordion-body px-2 py-1">
                    @foreach($categories as $category)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="flexCheck-c-{{ $category->id }}" name="c[]"
                                   value="{{ $category->id }}" {{ $f_categories->contains($category->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheck-c-{{ $category->id }}">{{ $category->name() }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading-b">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-b" aria-expanded="true" aria-controls="panelsStayOpen-collapse-b">
                    @lang('app.brands')
                </button>
            </h2>
            <div id="panelsStayOpen-collapse-b" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading-b">
                <div class="accordion-body px-2 py-1">
                    @foreach($brands as $brand)
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="flexCheck-b-{{ $brand->id }}" name="b[]"
                                   value="{{ $brand->id }}" {{ $f_brands->contains($brand->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheck-b-{{ $brand->id }}">{{ $brand->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-heading-s">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-s" aria-expanded="true" aria-controls="panelsStayOpen-collapse-s">
                    @lang('app.search')
                </button>
            </h2>
            <div id="panelsStayOpen-collapse-s" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading-s">
                <div class="accordion-body px-2 py-1">
                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" id="flexCheck-discount" name="d"
                               value="1" {{ $f_discount ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheck-discount">@lang('app.discount')</label>
                    </div>
                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" id="flexCheck-new" name="n"
                               value="1" {{ $f_new ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheck-new">@lang('app.new')</label>
                    </div>
                    <div class="form-check my-2">
                        <input class="form-check-input" type="checkbox" id="flexCheck-credit" name="t"
                               value="1" {{ $f_credit ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheck-credit">@lang('app.credit')</label>
                    </div>
                    @auth
                        <div class="form-check my-2">
                            <input class="form-check-input" type="checkbox" id="flexCheck-stock" name="s"
                                   value="1" {{ $f_outOfStock ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheck-stock">@lang('app.out-of-stock')</label>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        @foreach($options as $option)
            <div class="accordion-item">
                <h2 class="accordion-header" id="panelsStayOpen-heading-o{{ $option->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-o{{ $option->id }}" aria-expanded="false" aria-controls="panelsStayOpen-collapse-o{{ $option->id }}">
                        {{ $option->name }}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapse-o{{ $option->id }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading-o{{ $option->id }}">
                    <div class="accordion-body px-2 py-1">
                        @foreach($option->values as $value)
                            <div class="form-check my-2">
                                <input class="form-check-input" type="checkbox" id="flexCheck-v-{{ $value->id }}" name="v[{{ $option->id }}][]"
                                       value="{{ $value->id }}" {{ $f_values->contains($value->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheck-v-{{ $value->id }}">{{ $value->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="row {{ $options->count() + $brands->count() > 0 ? '' : 'd-none' }} g-2 my-1">
        <div class="col">
            <button type="submit" class="btn btn-danger btn-sm w-100"><i class="bi bi-funnel-fill"></i></button>
        </div>
        <div class="col">
            <a href="{{ url()->current() }}" class="btn btn-secondary btn-sm w-100"><i class="bi bi-trash-fill"></i></a>
        </div>
    </div>
</form>