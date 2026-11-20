<?php

use App\Models\Performance;
use App\Models\Ticket;
use App\TicketStatus;

it('books free tickets for a future performance', function () {
    $performance = Performance::factory()->create(['show_start' => now()->addDay(), 'capacity' => 3]);

    $this->get(route('bookings.create', $performance))->assertOk()->assertSee('Book your tickets');
    $this->post(route('bookings.store', $performance), ['name' => 'Alex Smith', 'email' => 'alex@example.com', 'quantity' => 2])
        ->assertRedirect(route('shows.show', $performance->show))->assertSessionHas('booking_confirmation');

    expect(Ticket::query()->where('performance_id', $performance->id)->where('status', TicketStatus::Bought->value)->where('buyer_email', 'alex@example.com')->where('cost_pence', 0)->count())->toBe(2);
});

it('rejects bookings after the performance starts', function () {
    $performance = Performance::factory()->create(['show_start' => now()->subMinute()]);

    $this->get(route('bookings.create', $performance))->assertNotFound();
    $this->post(route('bookings.store', $performance), ['name' => 'Alex Smith', 'email' => 'alex@example.com', 'quantity' => 1])->assertSessionHasErrors('quantity');
    expect(Ticket::query()->where('performance_id', $performance->id)->count())->toBe(0);
});

it('does not book beyond capacity including reserved tickets', function () {
    $performance = Performance::factory()->create(['show_start' => now()->addDay(), 'capacity' => 2]);
    Ticket::factory()->for($performance)->create(['status' => TicketStatus::Reserved]);

    $this->post(route('bookings.store', $performance), ['name' => 'Alex Smith', 'email' => 'alex@example.com', 'quantity' => 2])->assertSessionHasErrors('quantity');
    expect(Ticket::query()->where('performance_id', $performance->id)->count())->toBe(1);
});

it('validates booking details', function () {
    $performance = Performance::factory()->create(['show_start' => now()->addDay()]);

    $this->post(route('bookings.store', $performance), ['name' => '', 'email' => 'invalid', 'quantity' => 11])->assertSessionHasErrors(['name', 'email', 'quantity']);
    expect(Ticket::query()->where('performance_id', $performance->id)->count())->toBe(0);
});
