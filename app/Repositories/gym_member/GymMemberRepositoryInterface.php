<?php

namespace App\Repositories\gym_member;

use App\Models\GymMember;

interface GymMemberRepositoryInterface
{
    public function all($id);
    public function find($id);
    public function store(array $data) : GymMember;
    public function update($id, $data): GymMember;
    public function destroy($id);
}
