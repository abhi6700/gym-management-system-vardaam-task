<?php

namespace App\Repositories\gym;

use App\Models\Gym;

class GymRepository implements GymRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Gym $gym)
    {
        //
    }

    public function all($id)
    {
        return $this->gym->where('admin_id', $id)->get();
    }

    public function find($id)
    {
        return $this->gym->find($id);
    }

    public function store($data): Gym
    {
        return $this->gym->create($data);
    }

    public function update($id, $data): Gym
    {
        $gym = $this->gym->find($id);
        $gym->update($data);
        return $gym;
    }

    public function destroy($id)
    {
        $gym = $this->gym->find($id);
        $gym->delete();
    }
}
