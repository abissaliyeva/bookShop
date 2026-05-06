<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    {{-- METHOD 1: Viewport meta tag --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.edit_book') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #faf7f2; margin: 0; }

        .top-nav {
            background: #1a1a2e;
            border-bottom: 3px solid #c9a84c;
            padding: 0.6rem 1.5rem;
            /* METHOD 2: full % width */
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-nav a {
            font-family: 'Playfair Display', serif;
            color: #c9a84c;
            text-decoration: none;
            /* METHOD 4: vw font */
            font-size: clamp(1rem, 2.5vw, 1.4rem);
        }

        /* METHOD 4: vw heading */
        h2 { font-family: 'Playfair Display', serif; font-size: clamp(1.3rem, 3.5vw, 2rem); }

        .card { border-radius: 12px; border: none; }
        .btn-dark-gold { background: #1a1a2e; color: #c9a84c; border: 2px solid #c9a84c; font-weight: 600; }

        /* METHOD 2: % width wrapper */
        .form-wrapper { width: 92%; max-width: 600px; margin: 0 auto; }

        /* METHOD 3: current cover image scales down */
        .current-cover { max-width: 100%; width: 60px; height: 80px; object-fit: cover; border-radius: 6px; border: 2px solid #c9a84c; }

        /* METHOD 5: Media query */
        @media (max-width: 576px) {
            .form-wrapper { width: 97%; }
            .card { padding: 1rem !important; }
            .d-flex.gap-2 { flex-direction: column; }
            .d-flex.gap-2 .btn { width: 100%; }
        }
    </style>
</head>
<body>
<div class="top-nav">
    <a href="/">📚 BookShop</a>
    @include('partials.language_switcher')
</div>

<div class="container-fluid py-5">
    <div class="form-wrapper">
        <h2 class="mb-4">{{ __('messages.edit_book') }}</h2>

        <div class="card shadow-sm p-4">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.title') }}</label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $book->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.author') }}</label>
                    <input type="text" name="author"
                           class="form-control @error('author') is-invalid @enderror"
                           value="{{ old('author', $book->author) }}" required>
                    @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.price') }} ($)</label>
                    <input type="number" name="price" step="0.01" min="0"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price', $book->price) }}" required>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">{{ __('messages.cover_image') }}</label>

                    @if($book->cover_image)
                        <div class="mb-2 d-flex align-items-center gap-3">
                            {{-- METHOD 3: max-width:100% on current cover --}}
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 class="current-cover" alt="{{ $book->title }}">
                            <span class="text-muted small">{{ __('messages.current_cover') }}</span>
                        </div>
                    @endif

                    <input type="file" name="cover_image"
                           class="form-control @error('cover_image') is-invalid @enderror"
                           accept="image/jpg,image/jpeg,image/png,image/webp">
                    <div class="form-text">{{ __('messages.replace_hint') }}</div>
                    @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-dark-gold">{{ __('messages.save_changes') }}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        {{ __('messages.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>