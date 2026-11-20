<x-layouts.public title="Home">
    <section class="relative overflow-hidden bg-[#e8eee6]">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 lg:grid-cols-2 lg:px-10 lg:py-28">
            <div>
                <p class="text-xs font-bold tracking-[.22em] text-[#547568] uppercase">
                    <i class="fa-solid fa-sparkles mr-2" aria-hidden="true"></i> Stories worth remembering
                </p>
                <h1 class="mt-5 max-w-2xl font-serif text-5xl leading-[1.05] tracking-tight sm:text-7xl">
                    The stories don't end when the curtain falls.
                </h1>
                <p class="mt-7 max-w-lg text-lg leading-8 text-[#5b6b60]">
                    Discover the shows, performances and people that make our theatre. Explore the archive or find your
                    next night out.
                </p>
                <div class="mt-9 flex flex-wrap gap-3">
                    <a
                        href="{{ route('performances.index') }}"
                        class="rounded-full bg-[#183f35] px-6 py-3.5 text-sm font-semibold text-white"
                        >See what's on <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i></a
                    ><a
                        href="{{ route('shows.index') }}"
                        class="rounded-full border border-[#aabbb0] px-6 py-3.5 text-sm font-semibold"
                        >Explore the archive</a>
                </div>
            </div>
            <div
                aria-hidden="true"
                class="relative mx-auto grid aspect-[5/4] w-full max-w-lg place-items-center overflow-hidden rounded-t-full bg-[#d7e2d5] text-[#527a68]"
            >
                <div class="absolute inset-6 rounded-t-full border border-[#93ae9b]"></div>
                <div class="absolute inset-12 rounded-t-full border border-[#a8c0ad]"></div>
                <i class="fa-solid fa-masks-theater text-[9rem] opacity-80"></i
                ><span class="absolute bottom-8 text-xs font-bold tracking-[.25em] uppercase"
                    >Every performance has a story</span>
            </div>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold tracking-[.2em] text-[#a36a47] uppercase">Take your seat</p>
                <h2 class="mt-3 font-serif text-4xl">Coming up on stage</h2>
                <p class="mt-3 text-[#69756c]">There's nothing quite like being there.</p>
            </div>
            <a href="{{ route('performances.index') }}" class="text-sm font-bold text-[#315c4b]"
                >All performances <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i
            ></a>
        </div>
        <div class="mt-9 divide-y divide-[#e4e7df] border-y border-[#e4e7df]">
            @forelse ($performances as $performance)
                <div class="flex flex-wrap items-center justify-between gap-5 py-6">
                    <div class="flex items-center gap-5">
                        <div class="grid size-16 place-content-center rounded-xl bg-[#edf1e9] text-center text-[#315c4b]">
                            <span class="text-xs font-bold uppercase">{{ $performance->show_start->format('M') }}</span
                            ><span class="font-serif text-2xl">{{ $performance->show_start->format('d') }}</span>
                        </div>
                        <div>
                            <a
                                href="{{ route('shows.show', $performance->show) }}"
                                class="font-serif text-2xl hover:underline"
                            >{{ $performance->show->name }}</a>
                            <p class="mt-1 text-sm text-[#718075]">
                                <i class="fa-regular fa-clock mr-1" aria-hidden="true"></i>
                                {{ $performance->show_start->format('D, j M Y · g:ia') }} <span class="mx-2">·</span>
                                <i class="fa-solid fa-location-dot mr-1" aria-hidden="true"></i>
                                {{ $performance->venue?->name ?? 'Venue unavailable' }}
                            </p>
                        </div>
                    </div>
                    <a
                        href="{{ route('bookings.create', $performance) }}"
                        class="rounded-full border border-[#cbd5ca] px-5 py-2.5 text-sm font-semibold text-[#315c4b]"
                        >Book tickets <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i
                    ></a>
                </div>
            @empty
                <p class="py-8 text-[#718075]">
                    There are no upcoming performances just now. Explore the archive in the meantime.
                </p>
            @endforelse
        </div>
    </section>
    <section class="bg-[#f0ede6]">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-10">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold tracking-[.2em] text-[#a36a47] uppercase">A little theatre history</p>
                    <h2 class="mt-3 font-serif text-4xl">From the archive</h2>
                    <p class="mt-3 text-[#69756c]">
                        {{ number_format($showCount) }} productions, and the stories behind them.
                    </p>
                </div>
                <a href="{{ route('shows.index') }}" class="text-sm font-bold text-[#315c4b]"
                    >Browse all shows <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i
                ></a>
            </div>
            <div class="mt-9 grid gap-5 md:grid-cols-3">
                @forelse ($shows as $show)
                    @include('theatre.partials.show-card')
                @empty
                    <p class="text-[#718075]">No shows have been added yet.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.public>
