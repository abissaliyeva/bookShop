<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} – BookShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="/css/app.css"       rel="stylesheet">
    <link href="/css/dashboard.css" rel="stylesheet">
    <style>
        .book-cover {
            width: 100%;
            max-width: 100%;
            max-height: 480px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .book-cover-placeholder {
            width: 100%;
            min-height: 320px;
            background: linear-gradient(135deg, #1a1a2e, #2c3e50);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(4rem, 10vw, 7rem);
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 4vw, 2.6rem);
            line-height: 1.2;
        }
        .book-author {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: #6b7280;
        }
        .book-price {
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 700;
            color: #c9a84c;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0;
            border-bottom: 1px solid #f0ebe3;
            font-size: 0.95rem;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 500; }
        .breadcrumb-item a { color: #c9a84c; text-decoration: none; }
        .breadcrumb-item.active { color: #6b7280; }

        @media (max-width: 768px) {
            .book-detail-grid { flex-direction: column !important; }
            .book-cover-col   { width: 100% !important; text-align: center; }
            .book-info-col    { width: 100% !important; }
        }
    </style>
</head>
<body>

@include('partials.navbar')

<div class="container-fluid px-3 px-md-4 py-4" style="max-width: 1000px;">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">{{ __('messages.home') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('books.index') }}">{{ __('messages.catalog') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ $book->title }}</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Main detail card --}}
    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex gap-4 gap-md-5 book-detail-grid flex-wrap">

            {{-- Cover image col — METHOD 2: % width --}}
            <div class="book-cover-col" style="width: 35%; flex-shrink: 0;">
                @if($book->cover_image)
                    {{-- METHOD 3: max-width 100% --}}
                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                         alt="{{ $book->title }}"
                         class="book-cover">
                @else
                    <div class="book-cover-placeholder">📖</div>
                @endif
            </div>

            {{-- Info col --}}
            <div class="book-info-col flex-grow-1">

                <h1 class="book-title mb-1">{{ $book->title }}</h1>
                <p class="book-author mb-3">by {{ $book->author }}</p>

                <div class="book-price mb-4">${{ number_format($book->price, 2) }}</div>

                {{-- Book details table --}}
                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">{{ __('messages.title') }}</span>
                        <span>{{ $book->title }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">{{ __('messages.author') }}</span>
                        <span>{{ $book->author }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">{{ __('messages.price') }}</span>
                        <span class="fw-bold" style="color:#c9a84c;">
                            ${{ number_format($book->price, 2) }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Added</span>
                        <span>{{ $book->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Availability</span>
                        <span class="badge bg-success">In Stock</span>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="d-flex gap-2 flex-wrap">

                    @auth
                        @if(Auth::user()->hasPermissionTo('buy books') && !Auth::user()->is_banned)
                            <form action="{{ route('books.buy', $book) }}" method="POST">
                                @csrf
                                <button class="btn btn-dark-gold btn-lg">
                                    🛒 {{ __('messages.buy_now') }}
                                </button>
                            </form>

                        @elseif(Auth::user()->is_banned)
                            <button class="btn btn-secondary btn-lg" disabled>
                                {{ __('messages.suspended_btn') }}
                            </button>

                        @elseif(Auth::user()->hasPermissionTo('manage books'))
                            {{-- Manager / Admin see edit button --}}
                            <a href="{{ route('books.edit', $book) }}"
                               class="btn btn-outline-primary btn-lg">
                                ✏️ {{ __('messages.edit') }}
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-lg"
                                        onclick="return confirm('{{ __('messages.delete') }}?')">
                                    🗑 {{ __('messages.delete') }}
                                </button>
                            </form>
                        @endif

                    @else
                        <a href="{{ route('login') }}" class="btn btn-dark-gold btn-lg">
                            {{ __('messages.login') }} to Buy
                        </a>
                    @endauth

                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-lg">
                        ← {{ __('messages.catalog') }}
                    </a>

                </div>

            </div>
        </div>
    </div>

    {{-- Orders count badge (visible to managers/admins/moderators) --}}
    @auth
        @if(Auth::user()->hasPermissionTo('manage books') || Auth::user()->hasRole('moderator'))
            <div class="card shadow-sm p-3 mb-4 d-flex flex-row align-items-center gap-3">
                <span style="font-size:1.8rem;">📊</span>
                <div>
                    <div class="fw-bold">{{ $book->orders()->count() }} orders placed</div>
                    <div class="text-muted small">Total revenue: ${{ number_format($book->orders()->sum('price_paid'), 2) }}</div>
                </div>
            </div>
        @endif
    @endauth

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>