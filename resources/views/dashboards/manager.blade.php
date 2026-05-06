<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    {{-- METHOD 1: Viewport meta tag --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.manager_dashboard') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-bookshop px-3 px-md-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#navManager">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navManager">
        <div class="ms-auto d-flex flex-wrap align-items-center gap-2 gap-md-3 py-2 py-lg-0">
            @include('partials.language_switcher')
            <span class="role-badge role-manager">Manager</span>
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

    <h2 class="mb-4">{{ __('messages.manager_dashboard') }}</h2>

    {{-- Add book — METHOD 2: col-* % widths --}}
    <div class="card shadow-sm p-3 p-md-4 mb-4">
        <h5 class="mb-3">➕ {{ __('messages.add_book') }}</h5>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST"
              enctype="multipart/form-data"
              class="row g-2 g-md-3 add-book-form">
            @csrf
            <div class="col-12 col-md-3">
                <input type="text" name="title" class="form-control"
                       placeholder="{{ __('messages.title') }}"
                       value="{{ old('title') }}" required>
            </div>
            <div class="col-12 col-md-3">
                <input type="text" name="author" class="form-control"
                       placeholder="{{ __('messages.author') }}"
                       value="{{ old('author') }}" required>
            </div>
            <div class="col-6 col-md-2">
                <input type="number" name="price" step="0.01" min="0" class="form-control"
                       placeholder="{{ __('messages.price') }} $"
                       value="{{ old('price') }}" required>
            </div>
            <div class="col-6 col-md-2">
                <input type="file" name="cover_image" class="form-control"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <div class="form-text" style="font-size:0.72rem;">{{ __('messages.cover_hint') }}</div>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-dark-gold w-100">{{ __('messages.add_book') }}</button>
            </div>
        </form>
    </div>

    {{-- Books table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">📚 {{ __('messages.books_catalog') }} ({{ $books->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th class="hide-mobile">{{ __('messages.cover_image') }}</th>
                            <th>{{ __('messages.title') }}</th>
                            <th class="hide-mobile">{{ __('messages.author') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="ps-3 text-muted small">{{ $book->id }}</td>
                            <td class="hide-mobile">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         class="book-thumb" alt="{{ $book->title }}">
                                @else
                                    <div class="book-thumb-placeholder">📖</div>
                                @endif
                            </td>
                            <td><strong>{{ $book->title }}</strong></td>
                            <td class="text-muted hide-mobile">{{ $book->author }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap action-group">
                                    <a href="{{ route('books.edit', $book) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       style="font-size:0.75rem;">
                                        {{ __('messages.edit') }}
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                                style="font-size:0.75rem;"
                                                onclick="return confirm('{{ __('messages.delete') }}?')">
                                            {{ __('messages.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                {{ __('messages.no_books') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>