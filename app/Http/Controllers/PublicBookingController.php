<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\TicketStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PublicBookingController extends Controller
{
    public function create(Performance $performance): View
    {
        abort_unless($performance->show_start?->isFuture() ?? false, 404);

        return view('theatre.booking', ['performance' => $performance]);
    }

    public function store(Request $request, Performance $performance): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $quantity = $request->integer('quantity');
        $name = $request->string('name')->toString();
        $email = $request->string('email')->toString();

        DB::transaction(function () use ($performance, $quantity, $name, $email): void {
            $performance = Performance::query()->lockForUpdate()->findOrFail($performance->id);

            if (! $performance->show_start?->isFuture()) {
                throw ValidationException::withMessages(['quantity' => 'Booking is closed for this performance.']);
            }

            $allocated = $performance->tickets()->whereIn('status', [TicketStatus::Reserved->value, TicketStatus::Bought->value])->count();

            if ($allocated + $quantity > $performance->capacity) {
                throw ValidationException::withMessages(['quantity' => 'There are not enough tickets remaining for this performance.']);
            }

            for ($i = 0; $i < $quantity; $i++) {
                $performance->tickets()->create([
                    'status' => TicketStatus::Bought,
                    'cost_pence' => 0,
                    'buyer_name' => $name,
                    'buyer_email' => $email,
                ]);
            }
        });

        return redirect()->route('shows.show', $performance->show_id)->with('booking_confirmation', 'Your tickets are booked. Please keep this confirmation for your records.');
    }
}
