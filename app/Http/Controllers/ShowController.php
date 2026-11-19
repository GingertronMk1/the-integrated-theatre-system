<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class ShowController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Show::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Show::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Show $show): JsonResource
    {
        return new JsonResource($show);
    }

    public function update(Request $request, Show $show): JsonResource
    {
        $show->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($show)))->safe(array_keys($this->rules())));

        return new JsonResource($show);
    }

    public function destroy(Show $show): Response
    {
        $show->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Show $show = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'year' => ['nullable', 'string', 'max:255'],
            'playwright_id' => ['required', 'uuid', 'exists:playwrights,id'],
            'season_id' => ['required', 'uuid', 'exists:seasons,id'],
        ];
    }
}
