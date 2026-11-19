<?php

namespace App\Http\Controllers;

use App\Models\ShowCast;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class ShowCastController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(ShowCast::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(ShowCast::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(ShowCast $showCast): JsonResource
    {
        return new JsonResource($showCast);
    }

    public function update(Request $request, ShowCast $showCast): JsonResource
    {
        $showCast->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($showCast)))->safe(array_keys($this->rules())));

        return new JsonResource($showCast);
    }

    public function destroy(ShowCast $showCast): Response
    {
        $showCast->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?ShowCast $showCast = null): array
    {
        return [
            'show_id' => ['required', 'uuid', 'exists:shows,id'],
            'person_id' => ['required', 'uuid', 'exists:people,id'],
            'role_name' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
