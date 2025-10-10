<?php

namespace App\Repositories\gym;

use App\Models\Gym;

Interface GymRepositoryInterface
{
    public function all($id);
    public function find($id);
    public function store(array $data): Gym;
    public function update($id, $data): Gym;
    public function destroy($id);
}
