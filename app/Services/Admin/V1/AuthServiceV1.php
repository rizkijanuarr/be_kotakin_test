<?php

namespace App\Services\Admin\V1;

use App\Repositories\Interfaces\Admin\V1\AuthRepositoryInterfaceV1;

class AuthServiceV1
{
    protected $authRepositoryV1;

    public function __construct(AuthRepositoryInterfaceV1 $authRepositoryV1)
    {
        $this->authRepositoryV1 = $authRepositoryV1;
    }

    public function login(array $credentials)
    {
        return $this->authRepositoryV1->login($credentials);
    }

    public function refreshToken()
    {
        return $this->authRepositoryV1->refreshToken();
    }

    public function logout()
    {
        $this->authRepositoryV1->logout();
    }

    public function me()
    {
        return $this->authRepositoryV1->me();
    }
}
