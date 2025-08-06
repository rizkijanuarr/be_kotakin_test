<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\RoleRepositoryInterfaceV1;
use Illuminate\Support\Facades\Validator;

class RoleServiceV1
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterfaceV1 $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function findById($id)
    {
        return $this->roleRepository->findById($id);
    }

    public function create(array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'required|string|max:255'
        ])->validate();

        $validated['is_active'] = 1;
        return $this->roleRepository->create($validated);
    }

    public function update($id, array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'sometimes|string|max:255'
        ])->validate();

        return $this->roleRepository->update($id, $validated);
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }
}
