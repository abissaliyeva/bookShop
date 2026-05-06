<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #faf7f2; }
        .navbar-bookshop { background: #1a1a2e; border-bottom: 3px solid #c9a84c; }
        .navbar-bookshop .navbar-brand { font-family: 'Playfair Display', serif; color: #c9a84c !important; }
        .navbar-bookshop .nav-link { color: #e5e7eb !important; }
        .navbar-bookshop .nav-link:hover { color: #c9a84c !important; }
        .role-badge { font-size: 0.7rem; font-weight: 600; padding: 2px 8px; border-radius: 20px; text-transform: uppercase; }
        .role-admin     { background: #7c3aed22; color: #7c3aed; border: 1px solid #7c3aed55; }
        .role-manager   { background: #0891b222; color: #0891b2; border: 1px solid #0891b255; }
        .role-moderator { background: #d9770622; color: #d97706; border: 1px solid #d9770655; }
        .role-customer  { background: #16a34a22; color: #16a34a; border: 1px solid #16a34a55; }
        .card { border-radius: 12px; border: none; }
        .table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; }
        h2 { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-bookshop px-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="role-badge role-admin">Admin</span>
        <span class="text-muted small text-white">{{ Auth::user()->name }}</span>
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

    <h2 class="mb-4">Admin Dashboard</h2>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #7c3aed;">
                <div style="font-size:2rem;">👥</div>
                <div class="fs-3 fw-bold">{{ $users->count() }}</div>
                <div class="text-muted small">Total Users</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #c9a84c;">
                <div style="font-size:2rem;">📚</div>
                <div class="fs-3 fw-bold">{{ $books->count() }}</div>
                <div class="text-muted small">Books in Catalog</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #e74c3c;">
                <div style="font-size:2rem;">🚫</div>
                <div class="fs-3 fw-bold">{{ $users->where('is_banned', true)->count() }}</div>
                <div class="text-muted small">Banned Users</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #16a34a;">
                <div style="font-size:2rem;">🎭</div>
                <div class="fs-3 fw-bold">{{ $roles->count() }}</div>
                <div class="text-muted small">Roles</div>
            </div>
        </div>
    </div>

    {{-- Users table --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">User Management</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Assign Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="role-badge role-{{ $role->name }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->is_banned)
                                    <span class="badge bg-danger">Banned</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td>
                                @if(!$user->hasRole('admin'))
                                <form action="{{ route('admin.assign-role', $user) }}" method="POST" class="d-flex gap-1">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm" style="width:120px;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-outline-secondary" style="font-size:0.75rem;">Set</button>
                                </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                @if(!$user->hasRole('admin'))
                                <form action="{{ route('admin.toggle-ban', $user) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm {{ $user->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                            style="font-size:0.75rem;">
                                        {{ $user->is_banned ? 'Unban' : 'Ban' }}
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
        <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Books Catalog</h5>
            <a href="{{ route('manager.dashboard') }}" class="btn btn-sm"
               style="background:#1a1a2e;color:#c9a84c;border:2px solid #c9a84c;">Manage Books →</a>
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
                    @foreach($books as $book)
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
                            <td>{{ $book->title }}</td>
                            <td class="text-muted">{{ $book->author }}</td>
                            <td>${{ number_format($book->price, 2) }}</td>
                            <td class="d-flex gap-1 py-3">
                                <a href="{{ route('books.edit', $book) }}"
                                   class="btn btn-sm btn-outline-primary" style="font-size:0.75rem;">Edit</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="font-size:0.75rem;"
                                            onclick="return confirm('Delete this book?')">Delete</button>
                                </form>
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
</html> -->



<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.admin_dashboard') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #faf7f2; }
        .navbar-bookshop { background: #1a1a2e; border-bottom: 3px solid #c9a84c; }
        .navbar-bookshop .navbar-brand { font-family: 'Playfair Display', serif; color: #c9a84c !important; }
        .role-badge { font-size:0.7rem; font-weight:600; padding:2px 8px; border-radius:20px; text-transform:uppercase; }
        .role-admin     { background:#7c3aed22; color:#7c3aed; border:1px solid #7c3aed55; }
        .role-manager   { background:#0891b222; color:#0891b2; border:1px solid #0891b255; }
        .role-moderator { background:#d9770622; color:#d97706; border:1px solid #d9770655; }
        .role-customer  { background:#16a34a22; color:#16a34a; border:1px solid #16a34a55; }
        .card { border-radius:12px; border:none; }
        .table th { font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:#6b7280; }
        h2 { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-bookshop px-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>
    <div class="ms-auto d-flex align-items-center gap-3">
        @include('partials.language_switcher')
        <span class="role-badge role-admin">Admin</span>
        <span class="text-white small">{{ Auth::user()->name }}</span>
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

    <h2 class="mb-4">{{ __('messages.admin_dashboard') }}</h2>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #7c3aed;">
                <div style="font-size:2rem;">👥</div>
                <div class="fs-3 fw-bold">{{ $users->count() }}</div>
                <div class="text-muted small">{{ __('messages.total_users') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #c9a84c;">
                <div style="font-size:2rem;">📚</div>
                <div class="fs-3 fw-bold">{{ $books->count() }}</div>
                <div class="text-muted small">{{ __('messages.total_books') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #e74c3c;">
                <div style="font-size:2rem;">🚫</div>
                <div class="fs-3 fw-bold">{{ $users->where('is_banned', true)->count() }}</div>
                <div class="text-muted small">{{ __('messages.banned_users') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 text-center" style="border-left:4px solid #16a34a;">
                <div style="font-size:2rem;">🎭</div>
                <div class="fs-3 fw-bold">{{ $roles->count() }}</div>
                <div class="text-muted small">{{ __('messages.total_roles') }}</div>
            </div>
        </div>
    </div>

    {{-- Users --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('messages.user_management') }}</h5>
            <a href="{{ route('manager.dashboard') }}" class="btn btn-sm"
               style="background:#1a1a2e;color:#c9a84c;border:2px solid #c9a84c;">
                {{ __('messages.manage_books') }}
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.role') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.assign_role') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="role-badge role-{{ $role->name }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->is_banned)
                                    <span class="badge bg-danger">{{ __('messages.banned') }}</span>
                                @else
                                    <span class="badge bg-success">{{ __('messages.active') }}</span>
                                @endif
                            </td>
                            <td>
                                @if(!$user->hasRole('admin'))
                                <form action="{{ route('admin.assign-role', $user) }}" method="POST" class="d-flex gap-1">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm" style="width:120px;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-outline-secondary" style="font-size:0.75rem;">
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
                                    <button class="btn btn-sm {{ $user->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
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

    {{-- Books --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">{{ __('messages.books_catalog') }}</h5>
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
                    @foreach($books as $book)
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
                            <td>{{ $book->title }}</td>
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
                                            onclick="return confirm('{{ __('messages.delete') }}?')">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
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