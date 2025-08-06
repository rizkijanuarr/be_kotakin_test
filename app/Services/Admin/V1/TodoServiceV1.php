<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\TodoRepositoryInterfaceV1;
use Illuminate\Support\Facades\Auth;
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

    public function findById($id)
    {
        return $this->todoRepository->findById($id);
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

        $validatedData['user_id'] = Auth::id();

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
        $todo = $this->todoRepository->findById($id);

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

        if (isset($validatedData['image'])) {
            if ($todo->image && Storage::disk('public')->exists($todo->getRawOriginal('image'))) {
                Storage::disk('public')->delete($todo->getRawOriginal('image'));
            }
            $validatedData['image'] = $validatedData['image']->store('image/todo', 'public');
        }

        if (isset($validatedData['file'])) {
            if ($todo->file && Storage::disk('public')->exists($todo->getRawOriginal('file'))) {
                Storage::disk('public')->delete($todo->getRawOriginal('file'));
            }
            $validatedData['file'] = $validatedData['file']->store('file/todo', 'public');
        }

        return $this->todoRepository->update($id, $validatedData);
    }

    public function delete($id)
    {
        $todo = $this->todoRepository->findById($id);

        if ($todo->image && Storage::disk('public')->exists($todo->getRawOriginal('image'))) {
            Storage::disk('public')->delete($todo->getRawOriginal('image'));
        }

        if ($todo->file && Storage::disk('public')->exists($todo->getRawOriginal('file'))) {
            Storage::disk('public')->delete($todo->getRawOriginal('file'));
        }

        return $this->todoRepository->delete($id);
    }
}
