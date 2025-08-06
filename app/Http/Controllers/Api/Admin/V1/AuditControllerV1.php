<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\V1\AuditServiceV1;
use Illuminate\Http\Request;

class AuditControllerV1 extends Controller
{
    protected $auditService;

    public function __construct(AuditServiceV1 $auditService)
    {
        $this->auditService = $auditService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'event', 'auditable_type']);
        $audits = $this->auditService->getAll($filters);
        return BaseResponse::success($audits);
    }
}
