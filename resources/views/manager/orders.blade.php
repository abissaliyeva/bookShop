<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.order_history') }} – BookShop</title>
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

    <h2 class="mb-1">{{ __('messages.order_history') }}</h2>
    <p class="text-muted mb-4">All customer purchases across the store.</p>

    {{-- Summary stat --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #c9a84c;">
                <div class="stat-icon">🧾</div>
                <div class="stat-number">{{ $orders->total() }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm stat-card" style="border-left:4px solid #16a34a;">
                <div class="stat-icon">💰</div>
                <div class="stat-number">${{ number_format($orders->sum('price_paid'), 2) }}</div>
                <div class="stat-label">{{ __('messages.price_paid') }} (this page)</div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">🧾 All Orders</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th class="hide-mobile">Cover</th>
                            <th>{{ __('messages.title') }}</th>
                            <th class="hide-mobile">{{ __('messages.author') }}</th>
                            <th>Customer</th>
                            <th>{{ __('messages.price_paid') }}</th>
                            <th class="hide-mobile">{{ __('messages.ordered_at') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-3 text-muted small">{{ $order->id }}</td>
                            <td class="hide-mobile">
                                @if($order->book->cover_image)
                                    <img src="{{ asset('storage/' . $order->book->cover_image) }}"
                                         class="book-thumb" alt="{{ $order->book->title }}">
                                @else
                                    <div class="book-thumb-placeholder">📖</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $order->book->title }}</strong>
                            </td>
                            <td class="text-muted small hide-mobile">{{ $order->book->author }}</td>
                            <td>
                                <div class="small fw-600">{{ $order->user->name }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $order->user->email }}</div>
                            </td>
                            <td class="fw-bold" style="color:#c9a84c;">
                                ${{ number_format($order->price_paid, 2) }}
                            </td>
                            <td class="text-muted small hide-mobile">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No orders yet.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>