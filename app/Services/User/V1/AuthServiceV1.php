<?php

namespace App\Services\User\V1;

use App\Repositories\Interfaces\User\V1\AuthRepositoryInterfaceV1;

class AuthServiceV1
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterfaceV1 $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        return $this->authRepository->register($data);
    }

    public function login(array $credentials)
    {
        return $this->authRepository->login($credentials);
    }

    public function refreshToken()
    {
        return $this->authRepository->refreshToken();
    }

    public function logout()
    {
        $this->authRepository->logout();
    }

    public function me()
    {
        return $this->authRepository->me();
    }
}
