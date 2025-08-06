<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\UserRepositoryInterfaceV1;
use Illuminate\Support\Facades\Validator;

class UserServiceV1
{
    protected $userRepository;

    public function __construct(UserRepositoryInterfaceV1 $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function findById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function create(array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id'
        ])->validate();

        $validated['is_active'] = 1;
        return $this->userRepository->create($validated);
    }

    public function update($id, array $data)
    {
        $validated = Validator::make($data, [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$id,
            'password' => 'sometimes|string|min:6',
            'role_id' => 'sometimes|exists:roles,id'
        ])->validate();

        return $this->userRepository->update($id, $validated);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }
}
