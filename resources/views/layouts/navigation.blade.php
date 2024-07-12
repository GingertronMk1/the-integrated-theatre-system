<nav x-data="{ open: false }" class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <i class="fa-solid fa-masks-theater" id="app-logo"></i>
        </a>
        <!-- Navigation Links -->
        {{-- $navLinks is passed in from the AppServiceProvider --}}
        <ul class="navbar-nav text-white">
            @foreach ($navLinks as $navRoute => $navText)
                @if (is_array($navText))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __($navRoute) }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($navText as $dropdownRoute => $dropdownText)
                                <li>
                                    <a class="dropdown-item" href="{{ route($dropdownRoute) }}">
                                        {{ __($dropdownText) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route($navRoute) }}">
                            {{ __($navText) }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <!-- Settings Dropdown -->
        <div class="ms-auto">
            @auth
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn text-decoration-none dropdown-item">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
            @guest
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('login') }}">Log In</a>
            @endguest
        </div>
    </div>
</nav>
