<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\StatusRepositoryInterfaceV1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StatusServiceV1
{
    protected $statusRepository;

    public function __construct(StatusRepositoryInterfaceV1 $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function getAll()
    {
        return $this->statusRepository->getAll();
    }

    public function findById($id)
    {
        return $this->statusRepository->findById($id);
    }

    public function create(array $data)
    {
        $validatedData = Validator::make($data, [
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ])->validate();

        $validatedData['slug'] = Str::slug($validatedData['name']);
        return $this->statusRepository->create($validatedData);
    }

    public function update($id, array $data)
    {
        $validatedData = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'color' => 'sometimes|required|string|max:255',
        ])->validate();

        if (isset($validatedData['name'])) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        return $this->statusRepository->update($id, $validatedData);
    }

    public function delete($id)
    {
        return $this->statusRepository->delete($id);
    }
}
