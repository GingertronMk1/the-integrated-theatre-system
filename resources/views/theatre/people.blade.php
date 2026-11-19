<x-layouts::app :title="__('People')">
    <div class="mx-auto flex max-w-6xl flex-col gap-6">
        <header><h1 class="text-3xl font-semibold text-zinc-950 dark:text-white">People</h1><p class="mt-2 text-sm text-zinc-500">The people involved in your theatre.</p></header>
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900"><div class="divide-y divide-zinc-100 dark:divide-zinc-800">
            @forelse ($people as $person)<div class="flex flex-wrap items-center justify-between gap-2 px-5 py-4"><span class="font-medium text-zinc-950 dark:text-white">{{ $person->name ?: 'Unnamed person' }}</span><span class="text-sm text-zinc-500">{{ $person->start_year }} – {{ $person->end_year }}</span></div>@empty<p class="px-5 py-8 text-sm text-zinc-500">No people have been added yet.</p>@endforelse
        </div></div>
        {{ $people->links() }}
    </div>
</x-layouts::app>
