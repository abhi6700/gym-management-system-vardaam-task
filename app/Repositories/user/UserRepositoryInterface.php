<?php

namespace App\Repositories\user;

use App\Models\User;

interface UserRepositoryInterface
{
    public function store(array $data): User;
    public function update($id, $data): User;
}
