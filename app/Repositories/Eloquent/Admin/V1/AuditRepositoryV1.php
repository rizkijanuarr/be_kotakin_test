<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\AuditRepositoryInterfaceV1;
use OwenIt\Auditing\Models\Audit;

class AuditRepositoryV1 implements AuditRepositoryInterfaceV1
{
    public function getAll(array $filters = [])
    {
        $query = Audit::with(['user'])
            ->latest();

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['event'])) {
            $query->where('event', $filters['event']);
        }
        if (isset($filters['auditable_type'])) {
            $query->where('auditable_type', $filters['auditable_type']);
        }

        return $query->paginate(20);
    }
}
