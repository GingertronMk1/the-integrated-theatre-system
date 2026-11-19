<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class SeasonController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Season::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Season::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Season $season): JsonResource
    {
        return new JsonResource($season);
    }

    public function update(Request $request, Season $season): JsonResource
    {
        $season->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($season)))->safe(array_keys($this->rules())));

        return new JsonResource($season);
    }

    public function destroy(Season $season): Response
    {
        $season->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Season $season = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'colour' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
}
