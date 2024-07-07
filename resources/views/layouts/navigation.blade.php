<nav x-data="{ open: false }" class="nav">
    <a href="{{ route('dashboard') }}" class="nav__home-link">
        <i class="fa-solid fa-masks-theater" id="app-logo"></i>
    </a>
                <!-- Navigation Links -->
                {{-- $navLinks is passed in from the AppServiceProvider --}}
    <div class="nav__links">
        @foreach($navLinks as $navRoute => $navText)
            <a class="nav__link" href="{{ route($navRoute) }}" data-active="{{ request()->routeIs($navRoute) }}">
                {{ __($navText) }}
            </a>
        @endforeach
    </div>

    <!-- Settings Dropdown -->
    <div class="nav__user-menu">
        @auth
            <div
                class="nav__user-dropdown-button"
                x-data="{ open: false }"
                @click.outside="open = false"
                @click="open = !open"
            >
                <div>{{ Auth::user()->name }}</div>
                <i class="fas fa-chevron-down"></i>
                <div class="nav__user-dropdown" :class="open ? 'nav__user-dropdown--open' : ''">
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
                </div>
            </div>
        @endauth
        @guest
            <a href="{{ route('register') }}">Register</a>
            <a href="{{ route('login') }}">Log In</a>
        @endguest
    </div>
</nav>
