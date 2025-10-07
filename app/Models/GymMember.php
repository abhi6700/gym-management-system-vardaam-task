<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymMember extends Model
{
    protected $fillable = [
        'name',
        'email',
        'dob',
        'gym_id',
    ];

    public function gym_member_health()
    {
        return $this->hasMany(GymMemberHealth::class);
    }
}
