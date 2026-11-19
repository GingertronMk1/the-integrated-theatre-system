<?php

namespace App\Http\Controllers;

use App\Models\TrainingSessionPerson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class TrainingSessionPersonController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(TrainingSessionPerson::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(TrainingSessionPerson::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(TrainingSessionPerson $trainingSessionPerson): JsonResource
    {
        return new JsonResource($trainingSessionPerson);
    }

    public function update(Request $request, TrainingSessionPerson $trainingSessionPerson): JsonResource
    {
        $trainingSessionPerson->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($trainingSessionPerson)))->safe(array_keys($this->rules())));

        return new JsonResource($trainingSessionPerson);
    }

    public function destroy(TrainingSessionPerson $trainingSessionPerson): Response
    {
        $trainingSessionPerson->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?TrainingSessionPerson $trainingSessionPerson = null): array
    {
        return [
            'training_session_id' => ['required', 'uuid', 'exists:training_session,id'],
            'person_id' => ['required', 'uuid', 'exists:people,id'],
            'type' => ['required', 'in:trainer,trainee'],
        ];
    }
}
