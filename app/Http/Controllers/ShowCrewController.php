<?php

namespace App\Http\Controllers;

use App\Models\ShowCrew;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class ShowCrewController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(ShowCrew::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(ShowCrew::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(ShowCrew $showCrew): JsonResource
    {
        return new JsonResource($showCrew);
    }

    public function update(Request $request, ShowCrew $showCrew): JsonResource
    {
        $showCrew->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($showCrew)))->safe(array_keys($this->rules())));

        return new JsonResource($showCrew);
    }

    public function destroy(ShowCrew $showCrew): Response
    {
        $showCrew->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?ShowCrew $showCrew = null): array
    {
        return [
            'show_id' => ['required', 'uuid', 'exists:shows,id'],
            'person_id' => ['required', 'uuid', 'exists:people,id'],
            'role_id' => ['required', 'uuid', 'exists:roles,id'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
