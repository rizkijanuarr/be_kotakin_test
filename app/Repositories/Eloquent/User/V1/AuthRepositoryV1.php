<?php

namespace App\Repositories\Eloquent\User\V1;

use App\Models\User;
use App\Models\Role;
use App\Repositories\Interfaces\User\V1\AuthRepositoryInterfaceV1;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepositoryV1 implements AuthRepositoryInterfaceV1
{
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if (!isset($data['role_id'])) {
            $role = Role::where('name', 'USER')->first();
            $data['role_id'] = $role?->id;
        }
        return User::create($data);
    }

    public function login(array $credentials)
    {
        if (!$token = auth()->guard('api_user')->attempt($credentials)) {
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
        return auth()->guard('api_user')->user();
    }

    protected function respondWithToken($token)
    {
        return [
            'user'  => auth()->guard('api_user')->user(),
            'token' => $token,
        ];
    }
}
