<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\V1\UserServiceV1;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserControllerV1 extends Controller
{
    protected $userService;

    public function __construct(UserServiceV1 $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAll();
            return BaseResponse::success($users);
        } catch (\Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $this->userService->create($request->all());
            return BaseResponse::success($user);
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e->errors());
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->findById($id);
            return BaseResponse::success($user);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->update($id, $request->all());
            return BaseResponse::success($user);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
            return BaseResponse::success();
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }
}
