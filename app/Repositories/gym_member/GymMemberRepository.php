<?php

namespace App\Repositories\gym_member;

use App\Models\GymMember;

class GymMemberRepository implements GymMemberRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private GymMember $gym_member)
    {
        
    }

    public function all($id)
    {
        return $this->gym_member->where('gym_id', $id)->get();
    }

    public function find($id)
    {
        return $this->gym_member->find($id);
    }

    public function store($data) : GymMember
    {
        return $this->gym_member->create($data);
    }

    public function update($id, $data): GymMember
    {
        $gym_member = $this->gym_member->find($id);
        $gym_member->update($data);
        return $gym_member;
    }

    public function destroy($id)
    {
        $gym_member = $this->gym_member->find($id);
        $gym_member->delete();
    }   
}
