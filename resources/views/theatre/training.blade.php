<x-layouts.public title="Training">
    <section class="bg-[#242a28] text-white">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
            <p class="text-xs font-bold tracking-[.2em] text-[#e5b85c] uppercase">
                <i class="fa-solid fa-screwdriver-wrench mr-2" aria-hidden="true"></i> Behind the scenes / Training
            </p>
            <h1 class="mt-5 font-mono text-5xl font-bold tracking-tight sm:text-6xl">
                Skills for the stage<span class="text-[#e5b85c]">.</span>
            </h1>
            <p class="mt-5 max-w-2xl leading-8 text-[#b9c4bd]">
                Explore the practical skills, equipment and training that support the work behind every production.
            </p>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
        <div class="flex items-end justify-between gap-5 border-b-4 border-[#e5b85c] pb-5">
            <div>
                <p class="font-mono text-xs font-bold tracking-[.15em] text-[#92712e] uppercase">
                    Training directory / 01
                </p>
                <h2 class="mt-2 font-mono text-3xl font-bold">Training items</h2>
            </div>
            <i class="fa-solid fa-helmet-safety text-3xl text-[#c59d49]" aria-hidden="true"></i>
        </div>
        <div class="divide-y divide-[#d9ded8]">
            @forelse ($items as $item)
                <div class="flex flex-wrap items-center justify-between gap-4 py-6">
                    <div>
                        <h3 class="font-mono font-bold">{{ $item->name }}</h3>
                        <p class="mt-1 text-sm text-[#6d7971]">
                            {{ $item->trainingCategory?->name ?? 'Uncategorised' }}
                        </p>
                    </div>
                    @if ($item->dangerous)
                        <span class="bg-[#f5dfac] px-3 py-1 font-mono text-xs font-bold text-[#6e5013]"><i class="fa-solid fa-triangle-exclamation mr-1" aria-hidden="true"></i> Hazardous</span>
                    @endif
                </div>
            @empty
                <p class="py-8 text-[#718075]">No training items have been added yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $items->links() }}</div>
    </section>
</x-layouts.public>
