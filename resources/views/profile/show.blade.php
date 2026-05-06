<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.profile') }} – BookShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <style>
        .avatar {
            width: clamp(60px, 10vw, 90px);
            height: clamp(60px, 10vw, 90px);
            border-radius: 50%;
            background: linear-gradient(135deg, #1a1a2e, #c9a84c);
            display: flex; align-items: center; justify-content: center;
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            color: white; font-weight: 700; flex-shrink: 0;
        }
        .order-row:hover { background: #faf7f2; }

        @media (max-width: 768px) {
            .profile-grid { flex-direction: column !important; }
        }
    </style>
</head>
<body>

@include('partials.navbar')

<div class="container-fluid px-3 px-md-4 py-4" style="max-width:900px;">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    <h2 class="mb-4">{{ __('messages.profile') }}</h2>

    {{-- Profile header --}}
    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex align-items-center gap-4 profile-grid flex-wrap">
            <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div>
                <h4 class="mb-0" style="font-family:'Playfair Display',serif;">{{ $user->name }}</h4>
                <p class="text-muted mb-1">{{ $user->email }}</p>
                @foreach($user->roles as $role)
                    <span class="role-badge role-{{ $role->name }}">{{ $role->name }}</span>
                @endforeach
                @if($user->is_banned)
                    <span class="badge bg-danger ms-1">{{ __('messages.banned') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Edit info --}}
        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-4 h-100">
                <h5 class="mb-3">{{ __('messages.account_settings') }}</h5>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.name') }}</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.new_password') }}</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="••••••">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ __('messages.confirm_new_pass') }}</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="••••••">
                    </div>
                    <button class="btn btn-dark-gold w-100">{{ __('messages.save') }}</button>
                </form>
            </div>
        </div>

        {{-- Role-specific info panel --}}
        <div class="col-12 col-md-6">

            @if($user->hasRole('customer'))
                {{-- Customer: order history --}}
                <div class="card shadow-sm p-4 h-100">
                    <h5 class="mb-3">{{ __('messages.order_history') }}</h5>

                    @forelse($orders as $order)
                        <div class="d-flex align-items-center gap-3 py-2 border-bottom order-row">
                            @if($order->book->cover_image)
                                <img src="{{ asset('storage/' . $order->book->cover_image) }}"
                                     style="width:40px;height:55px;object-fit:cover;border-radius:4px;max-width:100%;">
                            @else
                                <div style="width:40px;height:55px;background:#f3f4f6;border-radius:4px;
                                            display:flex;align-items:center;justify-content:center;">📖</div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="fw-600 small">{{ $order->book->title }}</div>
                                <div class="text-muted" style="font-size:0.78rem;">
                                    {{ $order->created_at->format('d M Y') }}
                                </div>
                            </div>
                            <div class="fw-bold" style="color:#c9a84c;">
                                ${{ number_format($order->price_paid, 2) }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('messages.no_orders') }}</p>
                    @endforelse
                </div>

            @elseif($user->hasRole('manager'))
                {{-- Manager: responsibilities --}}
                <div class="card shadow-sm p-4 h-100">
                    <h5 class="mb-3">{{ __('messages.responsibilities') }}</h5>
                    <ul class="list-unstyled">
                        @foreach($user->getAllPermissions() as $perm)
                            <li class="py-1 border-bottom">
                                <span style="color:#c9a84c;">✓</span>
                                {{ ucfirst($perm->name) }}
                            </li>
                        @endforeach
                    </ul>
                </div>

            @elseif($user->hasRole('moderator') || $user->hasRole('admin'))
                {{-- Moderator/Admin: system info --}}
                <div class="card shadow-sm p-4 h-100">
                    <h5 class="mb-3">{{ __('messages.account_settings') }}</h5>
                    <ul class="list-unstyled">
                        @foreach($user->getAllPermissions() as $perm)
                            <li class="py-1 border-bottom">
                                <span style="color:#c9a84c;">✓</span>
                                {{ ucfirst($perm->name) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>