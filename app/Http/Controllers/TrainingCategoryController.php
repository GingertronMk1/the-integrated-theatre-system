<?php

namespace App\Http\Controllers;

use App\Models\TrainingCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class TrainingCategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(TrainingCategory::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(TrainingCategory::query()->create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(TrainingCategory $trainingCategory): JsonResource
    {
        return new JsonResource($trainingCategory);
    }

    public function update(Request $request, TrainingCategory $trainingCategory): JsonResource
    {
        $trainingCategory->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($trainingCategory)))->safe(array_keys($this->rules())));

        return new JsonResource($trainingCategory);
    }

    public function destroy(TrainingCategory $trainingCategory): Response
    {
        $trainingCategory->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?TrainingCategory $trainingCategory = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
