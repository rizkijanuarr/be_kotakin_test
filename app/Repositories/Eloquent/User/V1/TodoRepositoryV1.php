<?php

namespace App\Repositories\Eloquent\User\V1;

use App\Models\Todo;
use App\Repositories\Interfaces\User\V1\TodoRepositoryInterfaceV1;
use Illuminate\Support\Facades\Auth;

class TodoRepositoryV1 implements TodoRepositoryInterfaceV1
{
    public function getAll()
    {
        return Todo::with(['user', 'status', 'storyPoint'])
            ->where('user_id', Auth::id())
            ->where('is_active', 1)
            ->when(request()->q, function ($todos) {
                $todos->where('title', 'like', '%' . request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        return Todo::create($data);
    }

    public function update($id, array $data)
    {
        $todo = $this->findById($id);
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Forbidden');
        }
        $todo->update($data);
        return $todo->refresh();
    }

    public function findById($id)
    {
        $todo = Todo::with(['status','storyPoint'])->findOrFail($id);
        if ($todo->user_id !== Auth::id()) {
            abort(403, 'Forbidden');
        }
        return $todo;
    }
}
