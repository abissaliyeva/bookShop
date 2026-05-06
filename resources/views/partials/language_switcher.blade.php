<div class="dropdown">
    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
        🌐 {{ __('messages.language') }}
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
               href="{{ route('language.switch', 'en') }}">
                🇬🇧 {{ __('messages.lang_en') }}
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'ru' ? 'active' : '' }}"
               href="{{ route('language.switch', 'ru') }}">
                🇷🇺 {{ __('messages.lang_ru') }}
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ app()->getLocale() === 'kk' ? 'active' : '' }}"
               href="{{ route('language.switch', 'kk') }}">
                🇰🇿 {{ __('messages.lang_kk') }}
            </a>
        </li>
    </ul>
</div>