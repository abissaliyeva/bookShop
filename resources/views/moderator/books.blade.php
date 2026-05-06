<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.books_page') }} – BookShop</title>
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

    <h2 class="mb-4">{{ __('messages.books_page') }}</h2>

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
                                       class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">
                                        {{ __('messages.edit') }}
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" style="font-size:0.75rem;"
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