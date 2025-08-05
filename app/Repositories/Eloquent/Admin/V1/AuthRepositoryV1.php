<?php

namespace App\Repositories\Eloquent\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\AuthRepositoryInterfaceV1;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepositoryV1 implements AuthRepositoryInterfaceV1
{
    public function login(array $credentials)
    {
        if (!$token = auth()->guard('api_admin')->attempt($credentials)) {
            return null;
        }

        return $this->respondWithToken($token);
    }

    public function refreshToken()
    {
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());
        return $this->respondWithToken($refreshToken);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function me()
    {
        return auth()->guard('api_admin')->user();
    }

    protected function respondWithToken($token)
    {
        return [
            'user' => auth()->guard('api_admin')->user(),
            'token' => $token,
        ];
    }
}
