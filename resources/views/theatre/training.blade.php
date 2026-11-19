<x-layouts::app :title="__('Training')">
    <div class="mx-auto flex max-w-6xl flex-col gap-6">
        <header>
            <h1 class="text-3xl font-semibold text-zinc-950 dark:text-white">Training</h1>
            <p class="mt-2 text-sm text-zinc-500">Browse training items and their categories.</p>
        </header>
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse ($items as $item)
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4">
                        <div>
                            <p class="font-medium text-zinc-950 dark:text-white">{{ $item->name }}</p>
                            <p class="mt-1 text-sm text-zinc-500">{{ $item->trainingCategory->name }}</p>
                        </div>
                        @if ($item->dangerous)
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-900 dark:bg-amber-900/40 dark:text-amber-200">Hazardous</span>
                        @endif
                    </div>
                @empty
                    <p class="px-5 py-8 text-sm text-zinc-500">No training items have been added yet.</p>
                @endforelse
            </div>
        </div>
        {{ $items->links() }}
    </div>
</x-layouts::app>
