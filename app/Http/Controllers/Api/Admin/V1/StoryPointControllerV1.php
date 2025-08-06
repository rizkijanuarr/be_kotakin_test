<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\V1\StoryPointServiceV1;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoryPointControllerV1 extends Controller
{
    protected $storyPointService;

    public function __construct(StoryPointServiceV1 $storyPointService)
    {
        $this->storyPointService = $storyPointService;
    }

    public function index()
    {
        try {
            $statuses = $this->storyPointService->getAll();
            return BaseResponse::success($statuses);
        } catch (\Exception $e) {
            return BaseResponse::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $status = $this->storyPointService->create($request->all());
            return BaseResponse::success($status);
        } catch (ValidationException $e) {
            return BaseResponse::validationError($e->errors());
        }
    }

    public function show($id)
    {
        try {
            $status = $this->storyPointService->findById($id);
            return BaseResponse::success($status);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $status = $this->storyPointService->update($id, $request->all());
            return BaseResponse::success($status);
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->storyPointService->delete($id);
            return BaseResponse::success();
        } catch (ModelNotFoundException $e) {
            return BaseResponse::notFound($e->getMessage());
        }
    }
}
