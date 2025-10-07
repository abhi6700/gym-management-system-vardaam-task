<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymMemberHealth extends Model
{
    protected $fillable = [
        'height',
        'weight',
        'bmi',
        'gym_member_id',
        'date'
    ];

    public function gym_member(){
        return $this->belongsTo(GymMember::class);
    }
}
