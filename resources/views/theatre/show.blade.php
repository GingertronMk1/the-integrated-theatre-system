<x-layouts.public :title="$show->name">
    <section class="bg-[#e8eee6]">
        <div class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
            <a href="{{ route('shows.index') }}" class="text-sm font-semibold text-[#456d58]"
                ><i class="fa-solid fa-arrow-left mr-2" aria-hidden="true"></i> Show archive</a>
            <p class="mt-10 text-xs font-bold tracking-[.2em] text-[#a36a47] uppercase">
                {{ $show->season?->name ?? 'The archive' }}
                @if ($show->year) ·{{ $show->year }} @endif
            </p>
            <h1 class="mt-4 font-serif text-5xl sm:text-6xl">{{ $show->name }}</h1>
            <p class="mt-4 text-lg text-[#617367]">By {{ $show->playwright?->name ?? 'Unknown playwright' }}</p>
            @if ($show->description)
                <p class="mt-7 max-w-3xl leading-8 whitespace-pre-line text-[#53665a]">{{ $show->description }}</p>
            @endif
        </div>
    </section>
    <div class="mx-auto max-w-7xl px-6 py-14 lg:px-10">
        @if (session('booking_confirmation'))
            <div role="status" class="mb-8 rounded-xl bg-[#e1f1e4] p-5 text-[#245739]">
                <i class="fa-solid fa-circle-check mr-2" aria-hidden="true"></i>{{ session('booking_confirmation') }}
            </div>
        @endif
        <section>
            <p class="text-xs font-bold tracking-[.18em] text-[#a36a47] uppercase">On stage</p>
            <h2 class="mt-2 font-serif text-3xl">Performances</h2>
            <div class="mt-6 divide-y divide-[#e4e7df] border-y border-[#e4e7df]">
                @forelse ($show->performances as $performance)
                    <div class="flex flex-wrap items-center justify-between gap-4 py-5">
                        <div>
                            <p class="font-semibold">{{ $performance->show_start ?: 'Time not set' }}</p>
                            <p class="mt-1 text-sm text-[#718075]">
                                <i class="fa-solid fa-location-dot mr-2" aria-hidden="true"></i
                                >{{ $performance->venue?->name ?? 'Venue unavailable' }}
                            </p>
                        </div>
                        @if ($performance->show_start?->isFuture())
                            <a
                                href="{{ route('bookings.create', $performance) }}"
                                class="rounded-full bg-[#183f35] px-5 py-2.5 text-sm font-semibold text-white"
                                >Book tickets <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i
                            ></a>
                        @endif
                    </div>
                @empty
                    <p class="py-6 text-[#718075]">No performances yet.</p>
                @endforelse
            </div>
        </section>
        <div class="mt-16 grid gap-12 md:grid-cols-2">
            <section>
                <p class="text-xs font-bold tracking-[.18em] text-[#a36a47] uppercase">In the spotlight</p>
                <h2 class="mt-2 font-serif text-3xl">Cast</h2>
                <ul class="mt-5 divide-y divide-[#e4e7df]">
                    @forelse ($show->cast as $entry)
                        <li class="flex justify-between gap-4 py-4">
                            <span>{{ $entry->person?->name ?? 'Unnamed person' }}</span
                            ><span class="text-sm text-[#718075]">{{ $entry->role_name }}</span>
                        </li>
                    @empty
                        <li class="py-4 text-[#718075]">No cast added yet.</li>
                    @endforelse
                </ul>
            </section>
            <section>
                <p class="text-xs font-bold tracking-[.18em] text-[#a36a47] uppercase">Behind the scenes</p>
                <h2 class="mt-2 font-serif text-3xl">Crew</h2>
                <ul class="mt-5 divide-y divide-[#e4e7df]">
                    @forelse ($show->crew as $entry)
                        <li class="flex justify-between gap-4 py-4">
                            <span>{{ $entry->person?->name ?? 'Unnamed person' }}</span
                            ><span class="text-sm text-[#718075]">{{ $entry->role?->name ?? 'Role unavailable' }}</span>
                        </li>
                    @empty
                        <li class="py-4 text-[#718075]">No crew added yet.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </div>
</x-layouts.public>
