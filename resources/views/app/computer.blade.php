<div>
    <a href="{{ route('computer', $computer->slug) }}" class="position-relative d-flex justify-content-center align-items-center">
        <img src="{{ $computer->image() }}" alt="" class="img-fluid border rounded">
        @if($computer->isDiscount())
            <div class="position-absolute text-light small fw-bold bg-danger bg-opacity-75 rounded end-0 top-0 px-1 m-1">
                -{{ $computer->discount_percent }}%
            </div>
        @endif
        @if($computer->isNew())
            <div class="position-absolute text-light small fw-bold bg-warning bg-opacity-75 rounded start-0 top-0 px-1 m-1">
                @lang('app.new')
            </div>
        @endif
    </a>
    <div>
        <a href="{{ route('computer', $computer->slug) }}" class="d-block link-dark small fw-bold my-1 line-clamp-2" style="height:2.5rem;">
            {{ $computer->name }}
        </a>
        <a href="{{ route('computers', ['b' => [$computer->brand_id]]) }}" class="small fw-bold link-secondary">
            {{ $computer->brand->name }}
        </a>
        ∙
        <a href="{{ route('computers', ['c' => [$computer->category_id]]) }}" class="small fw-bold link-secondary">
            {{ $computer->category->name() }}
        </a>
        @auth
            ∙
            <span class="small fw-bold">
                {{ $computer->stock }}
            </span>
        @endauth
        <div class="small fw-bold">
            @if($computer->isDiscount())
                <span class="text-secondary"><s>{{ number_format($computer->price, 2, ".", " ") }}</s></span>
                <span class="text-danger">{{ number_format($computer->price(), 2, ".", " ") }} <small>TMT</small></span>
            @else
                <span class="text-primary">{{ number_format($computer->price, 2, ".", " ") }} <small>TMT</small></span>
            @endif
            @if($computer->credit)
                <i class="bi bi-patch-check-fill text-info"></i>
            @endif

            <a href="{{ route('computer.busket', $computer->slug) }}">
                @if (!in_array($computer->id, $busket))
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success"><i class="bi bi-plus-square-fill"></i></button>
                    </div>
                @elseif(in_array($computer->id, $busket))
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-danger"><i class="bi bi-dash-square"></i></button>
                    </div>
                @endif
            </a>
            
        </div>
    </div>
</div>