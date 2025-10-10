<?php

namespace App\Repositories\gym_member\health;

use App\Models\GymMemberHealth;
use App\Repositories\gym_member\Health\GymMemberHealthRepositoryInterface;

class GymMemberHealthRepository implements GymMemberHealthRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private GymMemberHealth $gym_member_health)
    {
        //
    }

    public function store(array $data) : GymMemberHealth
    {
        return $this->gym_member_health->create($data);
    }
}
