<?php

namespace App\Http\Controllers\Api\User\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\User\V1\AuthServiceV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthControllerV1 extends Controller
{
    protected $authService;

    public function __construct(AuthServiceV1 $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return BaseResponse::validationError($validator->errors());
        }

        $user = $this->authService->register($request->only(['name','email','password']));
        return BaseResponse::success($user, 'Registration success');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return BaseResponse::validationError($validator->errors());
        }

        $data = $this->authService->login($request->only('email','password'));
        if (!$data) {
            return BaseResponse::unauthorized();
        }
        return BaseResponse::success($data);
    }

    public function refreshToken()
    {
        return BaseResponse::success($this->authService->refreshToken());
    }

    public function logout()
    {
        $this->authService->logout();
        return BaseResponse::success();
    }

    public function me()
    {
        return BaseResponse::success($this->authService->me());
    }
}
