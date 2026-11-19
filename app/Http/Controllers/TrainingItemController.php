<?php

namespace App\Http\Controllers;

use App\Models\TrainingItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class TrainingItemController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(TrainingItem::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(TrainingItem::query()->create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(TrainingItem $trainingItem): JsonResource
    {
        return new JsonResource($trainingItem);
    }

    public function update(Request $request, TrainingItem $trainingItem): JsonResource
    {
        $trainingItem->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($trainingItem)))->safe(array_keys($this->rules())));

        return new JsonResource($trainingItem);
    }

    public function destroy(TrainingItem $trainingItem): Response
    {
        $trainingItem->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?TrainingItem $trainingItem = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'training_category_id' => ['required', 'uuid', 'exists:training_categories,id'],
            'dangerous' => ['required', 'boolean'],
        ];
    }
}
