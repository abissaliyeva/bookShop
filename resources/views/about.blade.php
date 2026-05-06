<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.about_us') }} – BookShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <style>
        .about-hero {
            background: linear-gradient(135deg, #1a1a2e, #2c3e50);
            color: white;
            padding: 5rem 0;
        }
        .about-hero h1 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3.5rem); }
        .about-hero p  { font-size: clamp(1rem, 2vw, 1.2rem); opacity: 0.85; }

        .section-icon { font-size: clamp(2rem, 4vw, 3rem); }

        .about-card {
            border-radius: 16px;
            border: none;
            padding: 2rem;
            height: 100%;
            transition: transform 0.2s;
        }
        .about-card:hover { transform: translateY(-4px); }

        @media (max-width: 576px) {
            .about-hero { padding: 3rem 0; }
        }
    </style>
</head>
<body>

@include('partials.navbar')

{{-- Hero --}}
<div class="about-hero text-center">
    <div class="container">
        <h1 class="mb-3">{{ __('messages.about_us') }}</h1>
        <p class="lead" style="max-width:600px; margin:0 auto;">
            {{ __('messages.mission_text') }}
        </p>
    </div>
</div>

<div class="container py-5">

    <div class="row g-4">

        {{-- Mission --}}
        <div class="col-12 col-md-4">
            <div class="card about-card shadow-sm text-center">
                <div class="section-icon mb-3">🎯</div>
                <h4 style="font-family:'Playfair Display',serif;">{{ __('messages.our_mission') }}</h4>
                <p class="text-muted">{{ __('messages.mission_text') }}</p>
            </div>
        </div>

        {{-- Values --}}
        <div class="col-12 col-md-4">
            <div class="card about-card shadow-sm text-center">
                <div class="section-icon mb-3">💎</div>
                <h4 style="font-family:'Playfair Display',serif;">{{ __('messages.our_values') }}</h4>
                <p class="text-muted">{{ __('messages.values_text') }}</p>
            </div>
        </div>

        {{-- History --}}
        <div class="col-12 col-md-4">
            <div class="card about-card shadow-sm text-center">
                <div class="section-icon mb-3">📖</div>
                <h4 style="font-family:'Playfair Display',serif;">{{ __('messages.our_history') }}</h4>
                <p class="text-muted">{{ __('messages.history_text') }}</p>
            </div>
        </div>

    </div>

    {{-- Team stats --}}
    <div class="row g-3 mt-4 text-center">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm p-3" style="border-left:4px solid #c9a84c;">
                <div style="font-size:clamp(1.5rem,4vw,2.5rem);font-weight:700;color:#c9a84c;">500+</div>
                <div class="text-muted small">{{ __('messages.total_books') }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm p-3" style="border-left:4px solid #1a1a2e;">
                <div style="font-size:clamp(1.5rem,4vw,2.5rem);font-weight:700;color:#1a1a2e;">10K+</div>
                <div class="text-muted small">{{ __('messages.total_users') }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm p-3" style="border-left:4px solid #16a34a;">
                <div style="font-size:clamp(1.5rem,4vw,2.5rem);font-weight:700;color:#16a34a;">50K+</div>
                <div class="text-muted small">{{ __('messages.order_history') }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm p-3" style="border-left:4px solid #7c3aed;">
                <div style="font-size:clamp(1.5rem,4vw,2.5rem);font-weight:700;color:#7c3aed;">4.9★</div>
                <div class="text-muted small">Rating</div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>