<?php

namespace App\Http\Controllers\Api\User\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\User\V1\TodoServiceV1;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TodoControllerV1 extends Controller
{
    protected $todoService;

    public function __construct(TodoServiceV1 $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index()
    {
        $todos = $this->todoService->getAll();
        return BaseResponse::success($todos);
    }

    public function store(Request $request)
    {
        try {
            $todo = $this->todoService->create($request->all());
            return BaseResponse::success($todo);
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e->errors());
        } catch (\Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $todo = $this->todoService->update($id, $request->all());
            return BaseResponse::success($todo);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e->errors());
        } catch (\Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }
}
