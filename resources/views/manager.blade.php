<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #faf7f2; }
        .navbar-bookshop { background: #1a1a2e; border-bottom: 3px solid #c9a84c; }
        .navbar-bookshop .navbar-brand { font-family: 'Playfair Display', serif; color: #c9a84c !important; }
        .navbar-bookshop .nav-link { color: #e5e7eb !important; }
        .role-badge { font-size: 0.7rem; font-weight: 600; padding: 2px 8px; border-radius: 20px; text-transform: uppercase; }
        .role-manager { background: #0891b222; color: #0891b2; border: 1px solid #0891b255; }
        .card { border-radius: 12px; border: none; }
        .table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; }
        h2 { font-family: 'Playfair Display', serif; }
        .btn-dark-gold { background: #1a1a2e; color: #c9a84c; border: 2px solid #c9a84c; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-bookshop px-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="role-badge role-manager">Manager</span>
        <span class="small text-white">{{ Auth::user()->name }}</span>
        <form action="/logout" method="POST" class="m-0">
            @csrf
            <button class="btn btn-sm btn-outline-light">Logout</button>
        </form>
    </div>
</nav>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="mb-4">Manager Dashboard</h2>

    {{-- Add book form --}}
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="mb-3">➕ Add New Book</h5>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        {{-- enctype="multipart/form-data" is required for file upload --}}
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-3">
                <input type="text" name="title" class="form-control"
                       placeholder="Title" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="author" class="form-control"
                       placeholder="Author" value="{{ old('author') }}" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="price" step="0.01" min="0"
                       class="form-control" placeholder="Price $"
                       value="{{ old('price') }}" required>
            </div>
            <div class="col-md-2">
                <input type="file" name="cover_image" class="form-control"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <div class="form-text">Cover (optional, max 2MB)</div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark-gold w-100">Add Book</button>
            </div>
        </form>
    </div>

    {{-- Books table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">📚 All Books ({{ $books->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $book->id }}</td>
                            <td>
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         style="width:40px;height:55px;object-fit:cover;border-radius:4px;">
                                @else
                                    <div style="width:40px;height:55px;background:#f3f4f6;border-radius:4px;
                                                display:flex;align-items:center;justify-content:center;">📖</div>
                                @endif
                            </td>
                            <td><strong>{{ $book->title }}</strong></td>
                            <td class="text-muted">{{ $book->author }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td class="d-flex gap-1 py-3">
                                <a href="{{ route('books.edit', $book) }}"
                                   class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">Edit</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="font-size:0.75rem;"
                                            onclick="return confirm('Delete \'{{ $book->title }}\'?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No books yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.manager_dashboard') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #faf7f2; }
        .navbar-bookshop { background: #1a1a2e; border-bottom: 3px solid #c9a84c; }
        .navbar-bookshop .navbar-brand { font-family: 'Playfair Display', serif; color: #c9a84c !important; }
        .role-badge { font-size:0.7rem; font-weight:600; padding:2px 8px; border-radius:20px; text-transform:uppercase; }
        .role-manager { background:#0891b222; color:#0891b2; border:1px solid #0891b255; }
        .card { border-radius: 12px; border: none; }
        .table th { font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:#6b7280; }
        h2 { font-family: 'Playfair Display', serif; }
        .btn-dark-gold { background:#1a1a2e; color:#c9a84c; border:2px solid #c9a84c; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-bookshop px-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        @include('partials.language_switcher')
        <span class="role-badge role-manager">Manager</span>
        <span class="small text-white">{{ Auth::user()->name }}</span>
        <form action="/logout" method="POST" class="m-0">
            @csrf
            <button class="btn btn-sm btn-outline-light">{{ __('messages.logout') }}</button>
        </form>
    </div>
</nav>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2 class="mb-4">{{ __('messages.manager_dashboard') }}</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h5 class="mb-3">➕ {{ __('messages.add_book') }}</h5>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-3">
                <input type="text" name="title" class="form-control"
                       placeholder="{{ __('messages.title') }}" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="author" class="form-control"
                       placeholder="{{ __('messages.author') }}" value="{{ old('author') }}" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="price" step="0.01" min="0" class="form-control"
                       placeholder="{{ __('messages.price') }} $" value="{{ old('price') }}" required>
            </div>
            <div class="col-md-2">
                <input type="file" name="cover_image" class="form-control"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <div class="form-text">{{ __('messages.cover_hint') }}</div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-dark-gold w-100">{{ __('messages.add_book') }}</button>
            </div>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">📚 {{ __('messages.books_catalog') }} ({{ $books->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>{{ __('messages.cover_image') }}</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.author') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $book->id }}</td>
                            <td>
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         style="width:40px;height:55px;object-fit:cover;border-radius:4px;">
                                @else
                                    <div style="width:40px;height:55px;background:#f3f4f6;border-radius:4px;
                                                display:flex;align-items:center;justify-content:center;">📖</div>
                                @endif
                            </td>
                            <td><strong>{{ $book->title }}</strong></td>
                            <td class="text-muted">{{ $book->author }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td class="d-flex gap-1 py-3">
                                <a href="{{ route('books.edit', $book) }}"
                                   class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">
                                    {{ __('messages.edit') }}
                                </a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="font-size:0.75rem;"
                                            onclick="return confirm('{{ __('messages.delete') }} \'{{ $book->title }}\'?')">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">{{ __('messages.no_books') }}</td></tr>
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