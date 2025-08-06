<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Models\User;
use App\Repositories\Interfaces\Admin\V1\UserRepositoryInterfaceV1;
use Illuminate\Support\Facades\Hash;

class UserRepositoryV1 implements UserRepositoryInterfaceV1
{
    public function getAll()
    {
        return User::with('role')
            ->where('is_active', 1)
            ->when(request()->q, function ($user) {
                $user = $user->where('email', 'like', '%' . request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function findById($id)
    {
        return User::with('role')->findOrFail($id);
    }

    public function create(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->findById($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user->refresh();
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        $user->is_active = 0;
        $user->deleted_at = now();
        return $user->save();
    }
}
