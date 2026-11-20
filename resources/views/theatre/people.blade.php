<x-layouts.public title="People">
    <section class="bg-[#e8eee6]">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-10">
            <p class="text-xs font-bold tracking-[.2em] text-[#668476] uppercase">The people behind the productions</p>
            <h1 class="mt-4 font-serif text-5xl sm:text-6xl">Our people</h1>
            <p class="mt-5 max-w-xl text-lg leading-8 text-[#617367]">
                Meet the people who have helped bring theatre to life.
            </p>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
        <div class="divide-y divide-[#e4e7df] border-y border-[#e4e7df]">
            @forelse ($people as $person)
                <div class="flex flex-wrap items-center justify-between gap-4 py-5">
                    <span class="font-semibold"
                        ><i class="fa-regular fa-user mr-3 text-[#87a08f]" aria-hidden="true"></i
                        >{{ $person->name ?: 'Unnamed person' }}</span
                    ><span class="text-sm text-[#718075]">{{ $person->start_year }} – {{ $person->end_year }}</span>
                </div>
            @empty
                <p class="py-8 text-[#718075]">No people have been added yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $people->links() }}</div>
    </section>
</x-layouts.public>
