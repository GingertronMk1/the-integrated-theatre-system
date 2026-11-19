<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class PersonController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Person::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Person::create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Person $person): JsonResource
    {
        return new JsonResource($person);
    }

    public function update(Request $request, Person $person): JsonResource
    {
        $person->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($person)))->safe(array_keys($this->rules())));

        return new JsonResource($person);
    }

    public function destroy(Person $person): Response
    {
        $person->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Person $person = null): array
    {
        return [
            'user_id' => ['nullable', 'uuid', 'exists:users,id', Rule::unique('people', 'user_id')->ignore($person?->id)],
            'name' => ['nullable', 'string', 'max:255'],
            'start_year' => ['required', 'string', 'max:255'],
            'end_year' => ['required', 'string', 'max:255'],
        ];
    }
}
