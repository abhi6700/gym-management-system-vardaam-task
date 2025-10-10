<?php

namespace App\Repositories\gym_member\Health;

use App\Models\GymMemberHealth;

interface GymMemberHealthRepositoryInterface
{
    public function store(array $data): GymMemberHealth;
}
