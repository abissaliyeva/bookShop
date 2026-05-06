<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Online Book Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink:    #1a1a2e;
            --gold:   #c9a84c;
            --cream:  #faf7f2;
            --muted:  #6b7280;
            --danger: #e74c3c;
        }
        body { font-family: 'DM Sans', sans-serif; background: var(--cream); color: var(--ink); }
        h1,h2,h3,.brand { font-family: 'Playfair Display', serif; }

        .navbar-bookshop {
            background: var(--ink);
            border-bottom: 3px solid var(--gold);
            padding: 0.8rem 0;
        }
        .navbar-bookshop .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--gold) !important;
            letter-spacing: 0.5px;
        }
        .navbar-bookshop .nav-link { color: #e5e7eb !important; font-size: 0.9rem; }
        .navbar-bookshop .nav-link:hover { color: var(--gold) !important; }

        .role-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .role-admin    { background: #7c3aed22; color: #7c3aed; border: 1px solid #7c3aed55; }
        .role-manager  { background: #0891b222; color: #0891b2; border: 1px solid #0891b255; }
        .role-moderator{ background: #d9770622; color: #d97706; border: 1px solid #d9770655; }
        .role-customer { background: #16a34a22; color: #16a34a; border: 1px solid #16a34a55; }

        .alert { border-radius: 8px; border: none; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-bookshop">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">📚 BookShop</a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">Catalog</a></li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                @auth
                    {{-- Role-specific dashboard link --}}
                    @if(auth()->user()->hasRole('admin'))
                        <a class="nav-link text-warning" href="{{ route('admin.dashboard') }}">
                            <span class="role-badge role-admin">Admin Panel</span>
                        </a>
                    @elseif(auth()->user()->hasRole('manager'))
                        <a class="nav-link" href="{{ route('manager.dashboard') }}">
                            <span class="role-badge role-manager">Manager Panel</span>
                        </a>
                    @elseif(auth()->user()->hasRole('moderator'))
                        <a class="nav-link" href="{{ route('moderator.dashboard') }}">
                            <span class="role-badge role-moderator">Mod Panel</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('customer.dashboard') }}">
                            <span class="role-badge role-customer">My Account</span>
                        </a>
                    @endif

                    <span class="text-muted small">{{ auth()->user()->name }}</span>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"    class="btn btn-sm btn-outline-light">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm" style="background:var(--gold);color:var(--ink);font-weight:600;">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<footer style="background:var(--ink); color:#9ca3af; border-top: 3px solid var(--gold);" class="py-4 mt-5">
    <div class="container text-center small">
        © {{ date('Y') }} Online Book Shop · All rights reserved
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>