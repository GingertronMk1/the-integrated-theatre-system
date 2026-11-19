<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class TicketController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Ticket::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Ticket::query()->create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Ticket $ticket): JsonResource
    {
        return new JsonResource($ticket);
    }

    public function update(Request $request, Ticket $ticket): JsonResource
    {
        $ticket->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($ticket)))->safe(array_keys($this->rules())));

        return new JsonResource($ticket);
    }

    public function destroy(Ticket $ticket): Response
    {
        $ticket->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Ticket $ticket = null): array
    {
        return [
            'performance_id' => ['required', 'uuid', 'exists:performances,id'],
            'status' => ['required', 'in:available,reserved,bought'],
            'cost_pence' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
