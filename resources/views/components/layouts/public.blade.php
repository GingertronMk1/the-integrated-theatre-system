@props(['title' => null, 'industrial' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => $title])
</head>
<body class="min-h-screen bg-[#faf9f6] text-[#222521] antialiased">
    <header class="border-b border-[#e6e4dc] bg-[#faf9f6]">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-5 px-6 py-6 lg:px-10">
            <a href="{{ route('home') }}" class="flex items-center gap-3 text-sm font-bold tracking-[.16em] uppercase">
                <span class="grid size-10 place-items-center rounded-full bg-[#183f35] text-white"
                    ><i class="fa-solid fa-masks-theater" aria-hidden="true"></i
                ></span>
                <span
                    >Theatre<span class="block text-[10px] font-medium tracking-[.22em] text-[#758078]"
                        >The archive</span
                    ></span>
            </a>
            <nav aria-label="Main navigation" class="flex flex-wrap items-center gap-5 text-sm font-semibold sm:gap-8">
                <a href="{{ route('shows.index') }}" class="hover:text-[#a36a47]">Show archive</a>
                <a href="{{ route('performances.index') }}" class="hover:text-[#a36a47]">What's on</a>
                <a href="{{ route('people.index') }}" class="hover:text-[#a36a47]">People</a>
                @guest
                    <a href="{{ route('login') }}" class="text-[#64736b]"
                        >Log in <i class="fa-solid fa-arrow-right-to-bracket ml-1" aria-hidden="true"></i
                    ></a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-[#64736b]">Dashboard</a>
                @endguest
            </nav>
        </div>
    </header>
    <main>{{ $slot }}</main>
    <footer class="mt-20 bg-[#183f35] text-[#e8eee8]">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 sm:grid-cols-2 lg:grid-cols-3 lg:px-10">
            <div>
                <p class="font-serif text-2xl">Theatre lives here.</p>
                <p class="mt-3 max-w-xs text-sm leading-6 text-[#bdcfc4]">
                    A home for the productions, performances and people who make theatre happen.
                </p>
            </div>
            <div>
                <p class="text-xs font-bold tracking-[.18em] text-[#aec5b6] uppercase">Explore</p>
                <div class="mt-4 grid gap-3 text-sm">
                    <a href="{{ route('shows.index') }}">Show archive</a
                    ><a href="{{ route('performances.index') }}">Performances</a
                    ><a href="{{ route('people.index') }}">People</a>
                </div>
            </div>
            <div>
                <p class="text-xs font-bold tracking-[.18em] text-[#aec5b6] uppercase">Behind the scenes</p>
                <a href="{{ route('training.index') }}" class="mt-4 inline-flex items-center gap-3 text-sm"
                    ><i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i> Training &amp; skills
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i
                ></a>
            </div>
        </div>
        <div class="mx-auto max-w-7xl border-t border-white/15 px-6 py-5 text-xs text-[#aec5b6] lg:px-10">
            {{ config('app.name') }} &nbsp; / &nbsp; Made for the love of theatre
        </div>
    </footer>
</body>
</html>
