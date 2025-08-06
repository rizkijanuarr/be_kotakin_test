<?php

namespace App\Repositories\Interfaces\User\V1;

interface TodoRepositoryInterfaceV1
{
    public function create(array $data);
    public function getAll();
    public function update($id, array $data);
    public function findById($id);
}
