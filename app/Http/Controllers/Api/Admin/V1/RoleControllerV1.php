<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\V1\RoleServiceV1;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleControllerV1 extends Controller
{
    protected $roleService;

    public function __construct(RoleServiceV1 $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        try {
            $roles = $this->roleService->getAll();
            return BaseResponse::success($roles);
        } catch (\Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $role = $this->roleService->create($request->all());
            return BaseResponse::success($role);
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e->errors());
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->findById($id);
            return BaseResponse::success($role);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = $this->roleService->update($id, $request->all());
            return BaseResponse::success($role);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleService->delete($id);
            return BaseResponse::success();
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }
}
