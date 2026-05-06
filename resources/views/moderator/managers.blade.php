<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.managers_page') }} – BookShop</title>
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

    <h2 class="mb-4">{{ __('messages.managers_page') }}</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">🧑‍💼 {{ __('messages.managers_page') }} ({{ $managers->count() }})</h5>
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
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.assign_role') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($managers as $manager)
                        <tr>
                            <td class="ps-3 text-muted small">{{ $manager->id }}</td>
                            <td>{{ $manager->name }}</td>
                            <td class="text-muted small hide-mobile">{{ $manager->email }}</td>
                            <td>
                                @foreach($manager->roles as $role)
                                    <span class="role-badge role-{{ $role->name }}">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span class="badge {{ $manager->is_banned ? 'bg-danger' : 'bg-success' }}">
                                    {{ $manager->is_banned ? __('messages.banned') : __('messages.active') }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('moderator.assign-role', $manager) }}" method="POST"
                                      class="d-flex gap-1 role-select-form">
                                    @csrf
                                    <select name="role" class="form-select form-select-sm" style="width:110px;">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ $manager->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-outline-secondary" style="font-size:0.75rem;">
                                        {{ __('messages.set') }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('moderator.toggle-ban', $manager) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm {{ $manager->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                            style="font-size:0.75rem;">
                                        {{ $manager->is_banned ? __('messages.unban') : __('messages.ban') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">{{ __('messages.no_managers') }}</td>
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