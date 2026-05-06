<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.moderator_dashboard') }}</title>
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

    <h2 class="mb-4">{{ __('messages.moderator_dashboard') }}</h2>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <a href="{{ route('moderator.customers') }}" class="text-decoration-none">
                <div class="card shadow-sm stat-card" style="border-left:4px solid #16a34a;">
                    <div class="stat-icon">👥</div>
                    <div class="stat-number">{{ $totalUsers }}</div>
                    <div class="stat-label">{{ __('messages.total_users') }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('moderator.books') }}" class="text-decoration-none">
                <div class="card shadow-sm stat-card" style="border-left:4px solid #c9a84c;">
                    <div class="stat-icon">📚</div>
                    <div class="stat-number">{{ $totalBooks }}</div>
                    <div class="stat-label">{{ __('messages.total_books') }}</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #e74c3c;">
                <div class="stat-icon">🚫</div>
                <div class="stat-number">{{ $bannedUsers }}</div>
                <div class="stat-label">{{ __('messages.banned_users') }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <a href="{{ route('moderator.managers') }}" class="text-decoration-none">
                <div class="card shadow-sm stat-card" style="border-left:4px solid #0891b2;">
                    <div class="stat-icon">🧑‍💼</div>
                    <div class="stat-number">{{ $totalManagers }}</div>
                    <div class="stat-label">{{ __('messages.total_managers') }}</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Quick links --}}
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <a href="{{ route('moderator.customers') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center h-100" style="border-radius:12px; transition:transform .2s;"
                     onmouseover="this.style.transform='translateY(-4px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size:2.5rem;">👥</div>
                    <h5 class="mt-2">{{ __('messages.customers_page') }}</h5>
                    <p class="text-muted small">View, ban and manage customers</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('moderator.books') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center h-100" style="border-radius:12px; transition:transform .2s;"
                     onmouseover="this.style.transform='translateY(-4px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size:2.5rem;">📚</div>
                    <h5 class="mt-2">{{ __('messages.books_page') }}</h5>
                    <p class="text-muted small">Manage the book catalog</p>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a href="{{ route('moderator.managers') }}" class="text-decoration-none">
                <div class="card shadow-sm p-4 text-center h-100" style="border-radius:12px; transition:transform .2s;"
                     onmouseover="this.style.transform='translateY(-4px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size:2.5rem;">🧑‍💼</div>
                    <h5 class="mt-2">{{ __('messages.managers_page') }}</h5>
                    <p class="text-muted small">Assign roles and manage managers</p>
                </div>
            </a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>