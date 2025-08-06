<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\StoryPointRepositoryInterfaceV1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoryPointServiceV1
{
    protected $storyPointRepository;

    public function __construct(StoryPointRepositoryInterfaceV1 $storyPointRepository)
    {
        $this->storyPointRepository = $storyPointRepository;
    }

    public function getAll()
    {
        return $this->storyPointRepository->getAll();
    }

    public function findById($id)
    {
        return $this->storyPointRepository->findById($id);
    }

    public function create(array $data)
    {
        $validatedData = Validator::make($data, [
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'hours' => 'required|string|max:255',
        ])->validate();

        return $this->storyPointRepository->create($validatedData);
    }

    public function update($id, array $data)
    {
        $validatedData = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'value' => 'sometimes|required|string|max:255',
            'hours' => 'sometimes|required|string|max:255',
        ])->validate();

        return $this->storyPointRepository->update($id, $validatedData);
    }

    public function delete($id)
    {
        return $this->storyPointRepository->delete($id);
    }
}
