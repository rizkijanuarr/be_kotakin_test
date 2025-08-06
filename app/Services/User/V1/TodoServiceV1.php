<?php

namespace App\Services\User\V1;

use App\Repositories\Interfaces\User\V1\TodoRepositoryInterfaceV1;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TodoServiceV1
{
    protected $todoRepository;

    public function __construct(TodoRepositoryInterfaceV1 $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getAll()
    {
        return $this->todoRepository->getAll();
    }

    public function create(array $data)
    {
        $validatedData = Validator::make($data, [
            'status_id' => 'required|exists:statuses,id',
            'story_point_id' => 'required|exists:story_points,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'nullable|file|mimes:pdf|min:20|max:500',
            'link' => 'nullable|url',
            'code' => 'nullable|json',
        ])->validate();

        if (isset($validatedData['image'])) {
            $validatedData['image'] = $validatedData['image']->store('image/todo', 'public');
        }
        if (isset($validatedData['file'])) {
            $validatedData['file'] = $validatedData['file']->store('file/todo', 'public');
        }
        return $this->todoRepository->create($validatedData);
    }

    public function update($id, array $data)
    {
        $validatedData = Validator::make($data, [
            'status_id' => 'sometimes|exists:statuses,id',
            'story_point_id' => 'sometimes|exists:story_points,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'nullable|file|mimes:pdf|min:20|max:500',
            'link' => 'nullable|url',
            'code' => 'nullable|json',
        ])->validate();

        return $this->todoRepository->update($id, $validatedData);
    }
}
