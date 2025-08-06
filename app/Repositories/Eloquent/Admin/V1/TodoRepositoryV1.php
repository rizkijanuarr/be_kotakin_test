<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Models\Todo;
use App\Repositories\Interfaces\Admin\V1\TodoRepositoryInterfaceV1;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class TodoRepositoryV1 implements TodoRepositoryInterfaceV1
{
    public function getAll()
    {
        return Todo::with(
            ['user', 'status', 'storyPoint']
        )->where('is_active', 1)
            ->when(request()->q, function ($todos) {
                $todos = $todos->where('title', 'like', '%' . request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function findById($id)
    {
        return Todo::with(
            ['user', 'status', 'storyPoint']
        )->findOrFail($id);
    }

    public function create(array $data)
    {
        $todo = Todo::create($data);
        return $todo;
    }

    public function update($id, array $data)
    {
        $todo = $this->findById($id);
        $todo->update($data);
        return $todo->refresh();
    }

    public function delete($id)
    {
        $todo = $this->findById($id);
        $todo->is_active = 0;
        $todo->deleted_at = now();
        return $todo->save();
    }
}
