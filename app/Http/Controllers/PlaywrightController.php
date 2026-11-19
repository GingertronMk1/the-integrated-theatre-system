<?php

namespace App\Http\Controllers;

use App\Models\Playwright;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class PlaywrightController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Playwright::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Playwright::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Playwright $playwright): JsonResource
    {
        return new JsonResource($playwright);
    }

    public function update(Request $request, Playwright $playwright): JsonResource
    {
        $playwright->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($playwright)))->safe(array_keys($this->rules())));

        return new JsonResource($playwright);
    }

    public function destroy(Playwright $playwright): Response
    {
        $playwright->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Playwright $playwright = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'external_links' => ['required', 'array'],
        ];
    }
}
