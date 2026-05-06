<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    {{-- METHOD 1: Viewport meta tag --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.admin_dashboard') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-bookshop px-3 px-md-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#navAdmin">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navAdmin">
        <div class="ms-auto d-flex flex-wrap align-items-center gap-2 gap-md-3 py-2 py-lg-0">
            @include('partials.language_switcher')
            <span class="role-badge role-admin">Admin</span>
            <span class="text-white small"><a href="{{ route('profile.show') }}" class="text-decoration-none text-white">{{ Auth::user()->name }}</a></span>
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

    <h2 class="mb-4">{{ __('messages.admin_dashboard') }}</h2>

    {{-- Stat cards — METHOD 2: % widths via Bootstrap col-* --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #7c3aed;">
                <div class="stat-icon">👥</div>
                <div class="stat-number">{{ $users->count() }}</div>
                <div class="stat-label">{{ __('messages.total_users') }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #c9a84c;">
                <div class="stat-icon">📚</div>
                <div class="stat-number">{{ $books->count() }}</div>
                <div class="stat-label">{{ __('messages.total_books') }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #e74c3c;">
                <div class="stat-icon">🚫</div>
                <div class="stat-number">{{ $users->where('is_banned', true)->count() }}</div>
                <div class="stat-label">{{ __('messages.banned_users') }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #16a34a;">
                <div class="stat-icon">🎭</div>
                <div class="stat-number">{{ $roles->count() }}</div>
                <div class="stat-label">{{ __('messages.total_roles') }}</div>
            </div>
        </div>
    </div>

    {{-- Users table --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3
                    d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h5 class="mb-0">{{ __('messages.user_management') }}</h5>
            <a href="{{ route('manager.dashboard') }}" class="btn btn-sm btn-dark-gold">
                {{ __('messages.manage_books') }}
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>{{ __('messages.name') }}</th>
                            <th class="hide-mobile">{{ __('messages.email') }}</th>
                            <th>{{ __('messages.role') }}</th>
                            <th class="hide-mobile">{{ __('messages.status') }}</th>
                            <th class="hide-mobile">{{ __('messages.assign_role') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="ps-3 text-muted small">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted small hide-mobile">{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="role-badge role-{{ $role->name }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td class="hide-mobile">
                                <span class="badge {{ $user->is_banned ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->is_banned ? __('messages.banned') : __('messages.active') }}
                                </span>
                            </td>
                            <td class="hide-mobile">
                                @if(!$user->hasRole('admin'))
                                    <form action="{{ route('admin.assign-role', $user) }}" method="POST"
                                          class="role-select-form">
                                        @csrf
                                        <select name="role" class="form-select form-select-sm"
                                                style="width:110px;">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-outline-secondary"
                                                style="font-size:0.75rem;">
                                            {{ __('messages.set') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if(!$user->hasRole('admin'))
                                    <form action="{{ route('admin.toggle-ban', $user) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm
                                            {{ $user->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                                style="font-size:0.75rem;">
                                            {{ $user->is_banned ? __('messages.unban') : __('messages.ban') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Books table --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">{{ __('messages.books_catalog') }}</h5>
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
                    @foreach($books as $book)
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
                            <td>{{ $book->title }}</td>
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
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>