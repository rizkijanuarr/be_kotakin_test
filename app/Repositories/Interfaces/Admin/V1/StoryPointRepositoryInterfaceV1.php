<?php

namespace App\Repositories\Interfaces\Admin\V1;

interface StoryPointRepositoryInterfaceV1
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
