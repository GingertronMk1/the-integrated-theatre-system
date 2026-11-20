<a
    href="{{ route('shows.show', $show) }}"
    class="group overflow-hidden rounded-2xl border border-[#e1e3da] bg-white transition hover:-translate-y-1 hover:shadow-lg"
>
    <div class="flex h-40 items-end justify-between bg-[#dfe8dc] p-6 text-[#456d58]">
        <i class="fa-solid fa-masks-theater text-5xl opacity-55" aria-hidden="true"></i
        ><span class="font-serif text-5xl opacity-25">{{ $show->year ?? '✦' }}</span>
    </div>
    <div class="p-6">
        <p class="text-xs font-bold tracking-[.14em] text-[#a36a47] uppercase">
            {{ $show->season?->name ?? 'The archive' }}
        </p>
        <h3 class="mt-2 font-serif text-2xl">{{ $show->name }}</h3>
        <p class="mt-2 text-sm text-[#718075]">{{ $show->playwright?->name ?? 'Playwright unavailable' }}</p>
        <p class="mt-6 text-sm font-semibold text-[#315c4b]">
            Explore production
            <i class="fa-solid fa-arrow-right ml-1 transition group-hover:translate-x-1" aria-hidden="true"></i>
        </p>
    </div>
</a>
