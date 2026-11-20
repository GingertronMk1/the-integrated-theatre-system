<x-layouts.public title="Performances">
    <section class="bg-[#e8eee6]">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-10">
            <p class="text-xs font-bold tracking-[.2em] text-[#668476] uppercase">Find your next night out</p>
            <h1 class="mt-4 font-serif text-5xl sm:text-6xl">Performances</h1>
            <p class="mt-5 max-w-xl text-lg leading-8 text-[#617367]">
                From upcoming nights on stage to performances past.
            </p>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
        <h2 class="font-serif text-3xl">On the stage</h2>
        <div class="mt-6 divide-y divide-[#e4e7df] border-y border-[#e4e7df]">
            @forelse ($performances as $performance)
                <div class="flex flex-wrap items-center justify-between gap-5 py-6">
                    <div>
                        <a
                            href="{{ route('shows.show', $performance->show) }}"
                            class="font-serif text-2xl hover:underline"
                        >{{ $performance->show->name }}</a>
                        <p class="mt-2 text-sm text-[#718075]">
                            <i class="fa-regular fa-calendar mr-2" aria-hidden="true"></i
                            >{{ $performance->show_start?->format('D, j M Y · g:ia') ?? 'Time not set' }}
                            <span class="mx-2">·</span
                            ><i class="fa-solid fa-location-dot mr-2" aria-hidden="true"></i
                            >{{ $performance->venue?->name ?? 'Venue unavailable' }}
                        </p>
                    </div>
                    @if ($performance->show_start?->isFuture())
                        <a
                            href="{{ route('bookings.create', $performance) }}"
                            class="rounded-full bg-[#183f35] px-5 py-2.5 text-sm font-semibold text-white"
                            >Book tickets <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i
                        ></a>
                    @else
                        <span class="text-sm text-[#8a958c]">{{ $performance->show_start ? 'Past performance' : 'Date to be announced' }}</span>
                    @endif
                </div>
            @empty
                <p class="py-8 text-[#718075]">No performances have been added yet.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $performances->links() }}</div>
    </section>
</x-layouts.public>
