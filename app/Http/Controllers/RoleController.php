<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class RoleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JsonResource::collection(Role::query()->paginate());
    }

    public function store(Request $request): JsonResource
    {
        return new JsonResource(Role::query()->create(Validator::make($request->all(), $this->rules())->safe(array_keys($this->rules()))));
    }

    public function show(Role $role): JsonResource
    {
        return new JsonResource($role);
    }

    public function update(Request $request, Role $role): JsonResource
    {
        $role->update(Validator::make($request->all(), array_map(fn (array $rules): array => ['sometimes', ...$rules], $this->rules($role)))->safe(array_keys($this->rules())));

        return new JsonResource($role);
    }

    public function destroy(Role $role): Response
    {
        $role->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, list<string|Unique>>
     */
    private function rules(?Role $role = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'sort' => ['sometimes', 'integer', 'min:0', 'max:4294967295'],
        ];
    }
}
