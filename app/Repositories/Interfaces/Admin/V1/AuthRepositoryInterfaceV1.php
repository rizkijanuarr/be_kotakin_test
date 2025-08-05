<?php

namespace App\Repositories\Interfaces\Admin\V1;

interface AuthRepositoryInterfaceV1
{
    public function login(array $credentials);
    public function refreshToken();
    public function logout();
    public function me();
}
