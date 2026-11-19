<x-layouts::app :title="__('Performances')">
    <div class="mx-auto flex max-w-6xl flex-col gap-6">
        <header>
            <h1 class="text-3xl font-semibold text-zinc-950 dark:text-white">Performances</h1>
            <p class="mt-2 text-sm text-zinc-500">Performance dates, venues and capacity.</p>
        </header>
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($performances as $performance)
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4">
                        <div>
                            <a
                                href="{{ route('shows.show', $performance->show) }}"
                                wire:navigate
                                class="font-medium text-zinc-950 hover:underline dark:text-white"
                            >{{ $performance->show->name }}</a>
                            <p class="mt-1 text-sm text-zinc-500">
                                {{ $performance->venue?->name ?? 'Venue unavailable' }} · Capacity {{ $performance->capacity }}
                            </p>
                        </div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $performance->show_start ?: 'Time not set' }}</span>
                    </div>
                @empty
                    <p class="px-5 py-8 text-sm text-zinc-500">No performances have been added yet.</p>
                @endforelse
            </div>
        </div>
        {{ $performances->links() }}
    </div>
</x-layouts::app>
