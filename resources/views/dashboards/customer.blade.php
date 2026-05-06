<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    {{-- METHOD 1: Viewport meta tag --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.my_account') }} – Book Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-bookshop px-3 px-md-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#navCustomer">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navCustomer">
        <div class="ms-auto d-flex flex-wrap align-items-center gap-2 gap-md-3 py-2 py-lg-0">
            @include('partials.language_switcher')
            <span class="role-badge role-customer">Customer</span>
            <span class="small text-white"><a href="{{ route('profile.show') }}" class="text-decoration-none text-white">{{ Auth::user()->name }}</a></span>
            <form action="/logout" method="POST" class="m-0">
                @csrf
                <button class="btn btn-sm btn-outline-light">{{ __('messages.logout') }}</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid px-3 px-md-4 py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="mb-1">{{ __('messages.welcome_user', ['name' => Auth::user()->name]) }}</h2>
    <p class="text-muted mb-4">{{ __('messages.browse_catalog') }}</p>

    @if(Auth::user()->is_banned)
        <div class="alert alert-danger">🚫 {{ __('messages.account_suspended') }}</div>
    @endif

    {{-- METHOD 2: % widths via Bootstrap responsive grid --}}
    <div class="row g-3 g-md-4 books-grid">
        @forelse($books as $book)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100" style="overflow:hidden;">

                    {{-- METHOD 3: max-width:100% via .book-card-cover --}}
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                             class="book-card-cover"
                             alt="{{ $book->title }}">
                    @else
                        <div class="book-card-cover-placeholder">📖</div>
                    @endif

                    <div class="card-body">
                        <h6 class="mb-1" style="font-family:'Playfair Display',serif;">
                            {{ $book->title }}
                        </h6>
                        <p class="text-muted small mb-2">{{ $book->author }}</p>
                        <span class="fw-bold" style="color:#c9a84c;">
                            ${{ number_format($book->price, 2) }}
                        </span>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3 px-3">
                        @if(!Auth::user()->is_banned)
                            <form action="{{ route('books.buy', $book) }}" method="POST">
                                @csrf
                                <button class="btn btn-dark-gold btn-sm w-100">
                                    🛒 {{ __('messages.buy_now') }}
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                {{ __('messages.suspended_btn') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                {{ __('messages.no_books') }}
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>