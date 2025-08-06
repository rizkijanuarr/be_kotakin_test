<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Models\Role;
use App\Repositories\Interfaces\Admin\V1\RoleRepositoryInterfaceV1;

class RoleRepositoryV1 implements RoleRepositoryInterfaceV1
{
    public function getAll()
    {
        return Role::where('is_active', 1)
            ->when(request()->q, function ($role) {
                $role = $role->where('email', 'like', '%' . request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function findById($id)
    {
        return Role::findOrFail($id);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update($id, array $data)
    {
        $role = $this->findById($id);
        $role->update($data);
        return $role->refresh();
    }

    public function delete($id)
    {
        $role = $this->findById($id);
        $role->is_active = 0;
        $role->deleted_at = now();
        return $role->save();
    }
}
