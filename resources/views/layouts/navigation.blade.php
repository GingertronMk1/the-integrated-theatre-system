<nav x-data="{ open: false }" class="nav">
    <a href="{{ route('dashboard') }}" class="nav__home-link">
        <i class="fa-solid fa-masks-theater" id="app-logo"></i>
    </a>
                <!-- Navigation Links -->
                {{-- $navLinks is passed in from the AppServiceProvider --}}
    <div class="nav__links">
        @foreach($navLinks as $navRoute => $navText)
            @if(is_array($navText))
            <x-dropdown class="nav__dropdown">
                <x-slot name="trigger">{{ __($navRoute) }}</x-slot>
                <x-slot name="content">
                @foreach($navText as $dropdownRoute => $dropdownText)
                    <a class="nav__dropdown-link" href="{{ route($dropdownRoute) }}" data-active="{{ request()->routeIs($dropdownRoute) }}">
                        {{ __($dropdownText) }}
                    </a>
                @endforeach
                </x-slot>
            </x-dropdown>
            @else
            <a class="nav__link" href="{{ route($navRoute) }}" data-active="{{ request()->routeIs($navRoute) }}">
                {{ __($navText) }}
            </a>
            @endif
        @endforeach
    </div>

    <!-- Settings Dropdown -->
    <div class="nav__user-menu">
        @auth
            <x-dropdown rightAligned="true">
                <x-slot name="trigger">
                    <span>{{ Auth::user()->name }}</span>
                </x-slot>
                <x-slot name="content">
                    <a href="{{ route('profile.edit') }}">
                        {{ __('Profile') }}
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </x-slot>
            </x-dropdown>
        @endauth
        @guest
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}">Log In</a>
        @endguest
    </div>
</nav>
