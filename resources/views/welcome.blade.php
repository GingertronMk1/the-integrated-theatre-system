<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head', ['title' => __('Welcome')])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-950 antialiased dark:bg-zinc-950 dark:text-white">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-6 sm:px-8">
        <header class="flex items-center justify-between gap-4 border-b border-zinc-200 py-6 dark:border-zinc-800">
            <a
                href="{{ route('home') }}"
                class="text-sm font-semibold tracking-tight sm:text-base"
            >{{ config('app.name') }}</a>
            <nav aria-label="Account" class="flex items-center gap-4 text-sm font-medium">
                <a
                    href="{{ route('dashboard') }}"
                    class="text-zinc-600 hover:text-zinc-950 dark:text-zinc-300 dark:hover:text-white"
                >Dashboard</a>
                @guest
                    <a
                        href="{{ route('login') }}"
                        class="text-zinc-600 hover:text-zinc-950 dark:text-zinc-300 dark:hover:text-white"
                    >Log in</a>
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="rounded-lg bg-zinc-900 px-4 py-2 text-white hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
                        >Register</a>
                    @endif
                @endguest
            </nav>
        </header>

        <main class="flex flex-1 flex-col justify-center py-16 sm:py-24">
            <p class="text-sm font-semibold tracking-widest text-amber-700 uppercase dark:text-amber-400">
                Theatre at a glance
            </p>
            <h1 class="mt-4 max-w-2xl text-4xl font-semibold tracking-tight sm:text-5xl">
                The Integrated Theatre System
            </h1>
            <p class="mt-4 max-w-xl text-base leading-7 text-zinc-600 dark:text-zinc-400">
                A place for the productions, performances and people that bring theatre together.
            </p>

            <dl class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach (['Shows' => $showCount, 'Performances' => $performanceCount, 'People' => $peopleCount] as $label => $count)
                    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                        <dt class="text-sm font-medium text-zinc-600 dark:text-zinc-400">{{ $label }}</dt>
                        <dd class="mt-3 text-4xl font-semibold tracking-tight">{{ number_format($count) }}</dd>
                    </div>
                @endforeach
            </dl>
        </main>
    </div>
</body>
</html>
