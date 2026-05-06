<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderator Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #faf7f2; }
        .navbar-bookshop { background: #1a1a2e; border-bottom: 3px solid #c9a84c; }
        .navbar-bookshop .navbar-brand { font-family: 'Playfair Display', serif; color: #c9a84c !important; }
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
        <span class="role-badge role-moderator">Moderator</span>
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

    <h2 class="mb-2">Moderator Dashboard</h2>
    <p class="text-muted mb-4">
        You can ban or unban <strong>customers</strong> and <strong>managers</strong>.
        You cannot touch admins or other moderators.
    </p>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">👥 All Users ({{ $users->count() }})</h5>
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
                            <th>Action</th>
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
                                @if(!$user->hasRole('admin') && !$user->hasRole('moderator'))
                                    <form action="{{ route('moderator.toggle-ban', $user) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm {{ $user->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                                style="font-size:0.75rem;">
                                            {{ $user->is_banned ? 'Unban' : 'Ban' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">— no access —</span>
                                @endif
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
    <title>{{ __('messages.moderator_dashboard') }}</title>
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
        <span class="role-badge role-moderator">Moderator</span>
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

    <h2 class="mb-2">{{ __('messages.moderator_dashboard') }}</h2>
    <p class="text-muted mb-4">{{ __('messages.mod_description') }}</p>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">👥 {{ __('messages.user_management') }} ({{ $users->count() }})</h5>
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
                                @if(!$user->hasRole('admin') && !$user->hasRole('moderator'))
                                    <form action="{{ route('moderator.toggle-ban', $user) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm {{ $user->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                                style="font-size:0.75rem;">
                                            {{ $user->is_banned ? __('messages.unban') : __('messages.ban') }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">{{ __('messages.no_access') }}</span>
                                @endif
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