<?php

namespace App\Repositories\Interfaces\User\V1;

interface AuthRepositoryInterfaceV1
{
    public function register(array $data);
    public function login(array $credentials);
    public function refreshToken();
    public function logout();
    public function me();
}
