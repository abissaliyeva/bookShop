<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.customers_page') }} – BookShop</title>
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

    <h2 class="mb-4">{{ __('messages.customers_page') }}</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="mb-0">👥 {{ __('messages.customers_page') }} ({{ $customers->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>{{ __('messages.name') }}</th>
                            <th class="hide-mobile">{{ __('messages.email') }}</th>
                            <th class="hide-mobile">{{ __('messages.ordered_at') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td class="ps-3 text-muted small">{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td class="text-muted small hide-mobile">{{ $customer->email }}</td>
                            <td class="text-muted small hide-mobile">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>
                            <td>
                                <span class="badge {{ $customer->is_banned ? 'bg-danger' : 'bg-success' }}">
                                    {{ $customer->is_banned ? __('messages.banned') : __('messages.active') }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('moderator.toggle-ban', $customer) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm {{ $customer->is_banned ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                            style="font-size:0.75rem;">
                                        {{ $customer->is_banned ? __('messages.unban') : __('messages.ban') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                {{ __('messages.no_customers') }}
                            </td>
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