<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Models\StoryPoint;
use App\Repositories\Interfaces\Admin\V1\StoryPointRepositoryInterfaceV1;
use Illuminate\Http\Request;

class StoryPointRepositoryV1 implements StoryPointRepositoryInterfaceV1
{
    public function getAll()
    {
        return StoryPoint::where('is_active', 1)
            ->when(request()->q, function ($storyPoints) {
                $storyPoints = $storyPoints->where('name', 'like', '%' . request()->q . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function findById($id)
    {
        return StoryPoint::findOrFail($id);
    }

    public function create(array $data)
    {
        return StoryPoint::create($data);
    }

    public function update($id, array $data)
    {
        $status = StoryPoint::find($id);
        if ($status) {
            $status->update($data);
            return $status;
        }
        return null;
    }

    public function delete($id)
    {
        $storyPoint = StoryPoint::findOrFail($id);
        $storyPoint->is_active = 0;
        $storyPoint->deleted_at = now();
        return $storyPoint->save();
    }
}
