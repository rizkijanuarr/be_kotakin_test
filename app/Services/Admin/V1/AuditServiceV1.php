<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\AuditRepositoryInterfaceV1;

class AuditServiceV1
{
    protected $auditRepository;

    public function __construct(AuditRepositoryInterfaceV1 $auditRepository)
    {
        $this->auditRepository = $auditRepository;
    }

    public function getAll(array $filters = [])
    {
        return $this->auditRepository->getAll($filters);
    }
}
