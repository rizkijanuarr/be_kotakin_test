<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Helpers\BaseResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\V1\AuthServiceV1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthControllerV1 extends Controller
{
    protected $authServiceV1;

    public function __construct(AuthServiceV1 $authServiceV1)
    {
        $this->authServiceV1 = $authServiceV1;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return BaseResponse::validationError($validator->errors());
        }

        $credentials = $request->only('email', 'password');
        $data = $this->authServiceV1->login($credentials);

        if (!$data) {
            return BaseResponse::unauthorized();
        }

        return BaseResponse::success($data);
    }

    public function refreshToken()
    {
        $data = $this->authServiceV1->refreshToken();
        return BaseResponse::success($data);
    }

    public function logout()
    {
        $this->authServiceV1->logout();
        return BaseResponse::success();
    }

    public function me()
    {
        $user = $this->authServiceV1->me();
        return BaseResponse::success($user);
    }
}
