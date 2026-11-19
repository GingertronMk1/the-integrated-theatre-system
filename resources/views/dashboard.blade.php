<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-8">
        <header class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-amber-700 dark:text-amber-400">Theatre workspace</p>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight text-zinc-950 dark:text-white">@auth Welcome, {{ auth()->user()->name }} @else Welcome @endauth</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Your productions, people and training in one place.</p>
            </div>
            @auth
                <flux:button :href="route('filament.admin.pages.dashboard')">Manage records</flux:button>
            @endauth
        </header>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([['Shows', $showCount, 'shows.index'], ['Performances', $performanceCount, 'performances.index'], ['People', $peopleCount, 'people.index'], ['Training items', $trainingCount, 'training.index']] as [$label, $count, $route])
                <a href="{{ route($route) }}" wire:navigate class="rounded-xl border border-zinc-200 bg-white p-5 transition hover:border-amber-400 dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-amber-500">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $label }}</span>
                    <span class="mt-3 block text-3xl font-semibold text-zinc-950 dark:text-white">{{ $count }}</span>
                </a>
            @endforeach
        </div>

        <section class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between gap-4 border-b border-zinc-200 px-5 py-4 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-950 dark:text-white">Recent shows</h2>
                <a href="{{ route('shows.index') }}" wire:navigate class="text-sm font-medium text-amber-700 hover:underline dark:text-amber-400">View all</a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($shows as $show)
                    <a href="{{ route('shows.show', $show) }}" wire:navigate class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <div><p class="font-medium text-zinc-950 dark:text-white">{{ $show->name }}</p><p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $show->playwright?->name ?? 'Playwright unavailable' }} · {{ $show->season?->name ?? 'Season unavailable' }}</p></div>
                        <span class="text-sm text-zinc-500">{{ $show->year }}</span>
                    </a>
                @empty
                    <p class="px-5 py-8 text-sm text-zinc-500">No shows have been added yet.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts::app>
