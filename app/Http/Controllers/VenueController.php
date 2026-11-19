<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class VenueController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Venue::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Venue::query()->create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Venue $venue): JsonResource
    {
        return new JsonResource($venue);
    }

    public function update(Request $request, Venue $venue): JsonResource
    {
        $venue->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($venue)))->safe(array_keys($this->rules())));

        return new JsonResource($venue);
    }

    public function destroy(Venue $venue): Response
    {
        $venue->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Venue $venue = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }
}
