{{-- Include: @include('partials.navbar') --}}
<nav class="navbar navbar-expand-lg navbar-bookshop px-3 px-md-4">
    <a class="navbar-brand" href="/">📚 BookShop</a>

    <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav me-auto gap-1">
            <li class="nav-item">
                <a class="nav-link text-white" href="/">{{ __('messages.home') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('books.index') }}">{{ __('messages.catalog') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('about') }}">{{ __('messages.about_us') }}</a>
            </li>

            @auth
                {{-- Role-specific nav links --}}
                @if(Auth::user()->hasRole('moderator'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('moderator.customers') }}">{{ __('messages.customers_page') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('moderator.books') }}">{{ __('messages.books_page') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('moderator.managers') }}">{{ __('messages.managers_page') }}</a>
                    </li>
                @endif

                @if(Auth::user()->hasRole('manager'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('manager.dashboard') }}">{{ __('messages.manage_books') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('manager.orders') }}">{{ __('messages.order_history') }}</a>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a>
                    </li>
                @endif
            @endauth
        </ul>

        <div class="d-flex flex-wrap align-items-center gap-2 py-2 py-lg-0">
            @include('partials.language_switcher')

            @auth
                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-light">
                    {{ __('messages.profile') }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">{{ __('messages.logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}"    class="btn btn-sm btn-outline-light">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-dark-gold">{{ __('messages.register') }}</a>
            @endauth
        </div>
    </div>
</nav>