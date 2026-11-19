<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class PerformanceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Performance::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Performance::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Performance $performance): JsonResource
    {
        return new JsonResource($performance);
    }

    public function update(Request $request, Performance $performance): JsonResource
    {
        $performance->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($performance)))->safe(array_keys($this->rules())));

        return new JsonResource($performance);
    }

    public function destroy(Performance $performance): Response
    {
        $performance->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Performance $performance = null): array
    {
        return [
            'show_id' => ['required', 'uuid', 'exists:shows,id'],
            'show_start' => ['nullable', 'string', 'max:255'],
            'venue_id' => ['required', 'uuid', 'exists:venues,id'],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }
}
