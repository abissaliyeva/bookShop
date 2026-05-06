<!DOCTYPE html>
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
</html>