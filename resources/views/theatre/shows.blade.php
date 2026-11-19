<x-layouts::app :title="__('Shows')">
    <div class="mx-auto flex max-w-6xl flex-col gap-6">
        <header><h1 class="text-3xl font-semibold text-zinc-950 dark:text-white">Shows</h1><p class="mt-2 text-sm text-zinc-500">Browse productions and their cast, crew and performances.</p></header>
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($shows as $show)
                <a href="{{ route('shows.show', $show) }}" wire:navigate class="flex min-h-40 flex-col justify-between gap-6 rounded-xl border border-zinc-200 bg-white p-5 hover:border-amber-400 dark:border-zinc-700 dark:bg-zinc-900">
                    <div><p class="text-xs font-medium uppercase tracking-wider text-amber-700 dark:text-amber-400">{{ $show->season?->name ?? 'Season unavailable' }}</p><h2 class="mt-2 text-lg font-semibold text-zinc-950 dark:text-white">{{ $show->name }}</h2><p class="mt-1 text-sm text-zinc-500">{{ $show->playwright?->name ?? 'Playwright unavailable' }}</p></div>
                    <span class="text-sm text-zinc-500">{{ $show->year ?? 'Year not set' }} <span aria-hidden="true">→</span></span>
                </a>
            @empty
                <p class="text-sm text-zinc-500">No shows have been added yet.</p>
            @endforelse
        </div>
        {{ $shows->links() }}
    </div>
</x-layouts::app>
