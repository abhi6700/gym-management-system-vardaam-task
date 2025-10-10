<?php

namespace App\Repositories\user;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private User $user)
    {
        //
    }

    public function store(array $data): User
    {
        return $this->user->create($data);
    }

    public function update($id, $data): User
    {
        $user = $this->user->find($id);
        $user->update($data);
        return $user;
    }
}
