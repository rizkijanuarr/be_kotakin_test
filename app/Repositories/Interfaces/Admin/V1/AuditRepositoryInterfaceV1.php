<?php

namespace App\Repositories\Interfaces\Admin\V1;

interface AuditRepositoryInterfaceV1
{
    public function getAll(array $filters = []);
}
