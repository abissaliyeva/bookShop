<!-- <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    {{-- METHOD 1: Viewport meta tag --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.books_catalog') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

{{-- ── Navbar ── --}}
<nav class="navbar navbar-expand-lg navbar-bookshop px-3 px-md-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>

    <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#navIndex">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navIndex">
        {{-- Left links --}}
        <ul class="navbar-nav me-auto gap-1">
            <li class="nav-item">
                <a class="nav-link text-white" href="/">{{ __('messages.home') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('books.index') }}">
                    {{ __('messages.catalog') }}
                </a>
            </li>
        </ul>

        {{-- Right: language + auth buttons --}}
        <div class="d-flex flex-wrap align-items-center gap-2 py-2 py-lg-0">
            @include('partials.language_switcher')

            @auth
                {{-- Redirect to correct dashboard based on role --}}
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-dark-gold">
                        {{ __('messages.admin_dashboard') }}
                    </a>
                @elseif(Auth::user()->hasRole('manager'))
                    <a href="{{ route('manager.dashboard') }}" class="btn btn-sm btn-dark-gold">
                        {{ __('messages.manager_dashboard') }}
                    </a>
                @elseif(Auth::user()->hasRole('moderator'))
                    <a href="{{ route('moderator.dashboard') }}" class="btn btn-sm btn-dark-gold">
                        {{ __('messages.moderator_dashboard') }}
                    </a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-sm btn-dark-gold">
                        {{ __('messages.my_account') }}
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">{{ __('messages.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">
                    {{ __('messages.login') }}
                </a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-dark-gold">
                    {{ __('messages.register') }}
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- ── Hero / Advertisement ── --}}
<div id="advertisement" class="py-5">
    <div class="container">
        {{-- METHOD 2: % widths via Bootstrap col-* --}}
        <div class="d-flex align-items-center hero-inner gap-4">

            <div class="col-md-4 text-center hero-img">
                {{-- METHOD 3: img-fluid = max-width:100% --}}
                <img src="franlenstein.jpg"
                     alt="Frankenstein Book"
                     class="img-fluid rounded shadow">
            </div>

            <div class="col-md-7 hero-text">
                <h1 class="mb-3">{{ __('messages.welcome_msg') }}</h1>
                <h2 class="mb-3">{{ __('messages.books_catalog') }}</h2>
                <p class="lead">{{ __('messages.browse_catalog') }}</p>

                @guest
                    <a href="{{ route('register') }}" class="btn btn-dark-gold mt-2">
                        {{ __('messages.register') }} →
                    </a>
                @endguest
            </div>

        </div>
    </div>
</div>

{{-- ── jQuery animation buttons ── --}}
<div class="text-center my-4 d-flex justify-content-center gap-2 jquery-buttons px-3">
    <button class="btn btn-warning btn-lg" id="openAd">Show</button>
    <button class="btn btn-light"          id="hideAd">{{ __('messages.cancel') }}</button>
    <button class="btn btn-light"          id="fadeInAd">fadeIn</button>
    <button class="btn btn-light"          id="fadeOutAd">fadeOut</button>
    <button class="btn btn-light"          id="fadeToAd">fadeTo</button>
    <button class="btn btn-light"          id="slideUpAd">slideUp</button>
    <button class="btn btn-light"          id="slideDownAd">slideDown</button>
    <button class="btn btn-warning"        id="animateAd">animate</button>
    <button class="btn btn-danger"         id="stopAd">stop</button>
</div>

{{-- ── Stats / Charts ── --}}
<div class="container my-5 stats-section">

    <h2 class="text-center mb-5">{{ __('messages.books_catalog') }}</h2>

    {{-- METHOD 2: Bootstrap % grid — 2 columns on md, 1 on mobile --}}
    <div class="row g-4">

        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="text-center">{{ __('messages.total_books') }}</h5>
                <canvas id="bar"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="text-center">{{ __('messages.total_users') }}</h5>
                <canvas id="pie"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="text-center">{{ __('messages.banned_users') }}</h5>
                <canvas id="line"></canvas>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="text-center">{{ __('messages.total_roles') }}</h5>
                <canvas id="polar"></canvas>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/script.js"></script>

</body>
</html> -->




<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.books_catalog') }} – BookShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="/css/app.css"       rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
</head>
<body>

@include('partials.navbar')

<div class="container-fluid px-3 px-md-4 py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="mb-4">{{ __('messages.all_books') }}</h2>

    {{-- Search bar --}}
    <form method="GET" action="{{ route('books.index') }}" class="mb-4">
        <div class="d-flex gap-2" style="max-width:500px;">
            <input type="text" name="search" class="form-control"
                   placeholder="{{ __('messages.search_books') }}"
                   value="{{ request('search') }}">
            <button class="btn btn-dark-gold">{{ __('messages.search') }}</button>
            @if(request('search'))
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">✕</a>
            @endif
        </div>
    </form>

    {{-- Grid --}}
    <div class="row g-3 g-md-4 books-grid">
        @forelse($books as $book)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100" style="overflow:hidden; border-radius:12px;">

                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                             class="book-card-cover" alt="{{ $book->title }}">
                    @else
                        <div class="book-card-cover-placeholder">📖</div>
                    @endif

                    <div class="card-body">
                        <h6 class="mb-1" style="font-family:'Playfair Display',serif;">{{ $book->title }}</h6>
                        <p class="text-muted small mb-2">{{ $book->author }}</p>
                        <span class="fw-bold" style="color:#c9a84c;">${{ number_format($book->price, 2) }}</span>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3 px-3">
                        @auth
                            @if(Auth::user()->hasPermissionTo('buy books') && !Auth::user()->is_banned)
                                <form action="{{ route('books.buy', $book) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-dark-gold btn-sm w-100">
                                        🛒 {{ __('messages.buy_now') }}
                                    </button>
                                </form>
                            @elseif(Auth::user()->is_banned)
                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                    {{ __('messages.suspended_btn') }}
                                </button>
                            @else
                                <a href="{{ route('books.show', $book) }}"
                                   class="btn btn-outline-secondary btn-sm w-100">
                                    View Details
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-dark-gold btn-sm w-100">
                                {{ __('messages.login') }} to Buy
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                {{ request('search') ? __('messages.no_results') : __('messages.no_books') }}
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $books->links() }}
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>