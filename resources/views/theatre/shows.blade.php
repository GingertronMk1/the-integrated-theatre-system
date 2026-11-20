<x-layouts.public title="Show archive">
    <section class="bg-[#e8eee6]">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-10">
            <p class="text-xs font-bold tracking-[.2em] text-[#668476] uppercase">The stories we share</p>
            <h1 class="mt-4 font-serif text-5xl sm:text-6xl">The show archive</h1>
            <p class="mt-5 max-w-xl text-lg leading-8 text-[#617367]">
                Explore the productions, performers and people that have brought our stage to life.
            </p>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
        <div class="mb-8 flex items-center justify-between">
            <h2 class="font-serif text-3xl">All productions</h2>
            <span class="text-sm text-[#718075]">{{ $shows->total() }} shows</span>
        </div>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($shows as $show)
                @include('theatre.partials.show-card')
            @empty
                <p class="text-[#718075]">No shows have been added yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $shows->links() }}</div>
    </section>
</x-layouts.public>
