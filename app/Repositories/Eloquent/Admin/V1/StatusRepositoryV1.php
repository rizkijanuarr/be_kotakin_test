<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Models\Status;
use App\Repositories\Interfaces\Admin\V1\StatusRepositoryInterfaceV1;
use Illuminate\Http\Request;

class StatusRepositoryV1 implements StatusRepositoryInterfaceV1
{
    public function getAll()
    {
        return Status::where('is_active', 1)
            ->when(request()->q, function ($statuses) {
                $statuses = $statuses->where('name', 'like', '%' . request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function findById($id)
    {
        return Status::findOrFail($id);
    }

    public function create(array $data)
    {
        return Status::create($data);
    }

    public function update($id, array $data)
    {
        $status = Status::find($id);
        if ($status) {
            $status->update($data);
            return $status;
        }
        return null;
    }

    public function delete($id)
    {
        $status = Status::findOrFail($id);
        $status->is_active = 0;
        $status->deleted_at = now();
        return $status->save();
    }
}
