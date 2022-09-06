<nav class="navbar navbar-expand-lg navbar-dark bg-primary" aria-label="navbar">
    <div class="container-xxl">
        <a class="navbar-brand" href="{{ route('home') }}">@lang('app.app-name')</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-md-center" id="navbars">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link fw-bold dropdown-toggle" href="#" id="dropdown02" data-bs-toggle="dropdown" aria-expanded="false">@lang('app.categories')</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown02">
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('computers', ['c' => [$category->id]]) }}">
                                    {{ $category->name() }} <span class="badge bg-light text-dark">{{ $category->computers_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link fw-bold dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">@lang('app.brands')</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown01">
                        @foreach($brands as $brand)
                            <li>
                                <a class="dropdown-item" href="{{ route('computers', ['b' => [$brand->id]]) }}">
                                    {{ $brand->name }} <span class="badge bg-light text-dark">{{ $brand->computers_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('about') }}">@lang('app.about-us')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('contact') }}">@lang('app.contact')</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('computer.create') }}">@lang('app.create')</a>
                    </li>
                @endauth
                @if(app()->isLocale('tm'))
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('language', 'en') }}">ENG</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('language', 'tm') }}">TKM</a>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('busket') }}">
                        <i class="bi bi-bag-heart-fill"></i> @lang('app.busket')
                    </a>
                </li>


                @guest
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> @lang('app.login')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> @lang('app.register')
                        </a>
                    </li>
                @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="bi bi-box-arrow-right"></i> @lang('app.logout') <span class="text-warning">{{ auth()->user()->name }}</span>
                        </a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                    </form>
                @endauth
            </ul>
        </div>
    </div>
</nav>
