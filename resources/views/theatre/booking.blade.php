<x-layouts.public title="Book tickets">
    <div class="mx-auto max-w-3xl px-6 py-16">
        <a href="{{ route('shows.show', $performance->show) }}" class="text-sm font-semibold text-[#456d58]"
            ><i class="fa-solid fa-arrow-left mr-2" aria-hidden="true"></i> Back to {{ $performance->show->name }}</a>
        <p class="mt-10 text-xs font-bold tracking-[.2em] text-[#a36a47] uppercase">Your night at the theatre</p>
        <h1 class="mt-3 font-serif text-5xl">Book your tickets</h1>
        <div class="mt-8 rounded-2xl bg-[#e8eee6] p-6">
            <p class="font-serif text-2xl">{{ $performance->show->name }}</p>
            <p class="mt-3 text-sm text-[#617367]">
                <i class="fa-regular fa-calendar mr-2" aria-hidden="true"></i
                >{{ $performance->show_start->format('l, j F Y · g:ia') }}
            </p>
            <p class="mt-2 text-sm text-[#617367]">
                <i class="fa-solid fa-location-dot mr-2" aria-hidden="true"></i
                >{{ $performance->venue?->name ?? 'Venue unavailable' }}
            </p>
        </div>
        <p class="mt-7 text-[#617367]">Tickets are free. Enter your details below to book your place.</p>
        <form method="POST" action="{{ route('bookings.store', $performance) }}" class="mt-7 grid gap-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold">Your name</label
                ><input
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    maxlength="255"
                    autocomplete="name"
                    class="mt-2 w-full rounded-lg border border-[#cfd7cc] bg-white px-4 py-3"
                />
                @error('name')
                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold">Email address</label
                ><input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    maxlength="255"
                    autocomplete="email"
                    class="mt-2 w-full rounded-lg border border-[#cfd7cc] bg-white px-4 py-3"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="quantity" class="block text-sm font-semibold">Number of tickets</label
                ><input
                    id="quantity"
                    name="quantity"
                    type="number"
                    min="1"
                    max="10"
                    value="{{ old('quantity', 1) }}"
                    required
                    class="mt-2 w-full rounded-lg border border-[#cfd7cc] bg-white px-4 py-3"
                />
                @error('quantity')
                    <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                @enderror
            </div>
            <button
                class="mt-2 w-fit rounded-full bg-[#183f35] px-7 py-3.5 text-sm font-semibold text-white"
                type="submit"
            >
                Confirm booking <i class="fa-solid fa-arrow-right ml-2" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</x-layouts.public>
