<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class TrainingSessionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(TrainingSession::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(TrainingSession::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(TrainingSession $trainingSession): JsonResource
    {
        return new JsonResource($trainingSession);
    }

    public function update(Request $request, TrainingSession $trainingSession): JsonResource
    {
        $trainingSession->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($trainingSession)))->safe(array_keys($this->rules())));

        return new JsonResource($trainingSession);
    }

    public function destroy(TrainingSession $trainingSession): Response
    {
        $trainingSession->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?TrainingSession $trainingSession = null): array
    {
        return [
            'training_item_id' => ['required', 'uuid', 'exists:training_items,id'],
            'occurred_at' => ['required', 'date'],
        ];
    }
}
