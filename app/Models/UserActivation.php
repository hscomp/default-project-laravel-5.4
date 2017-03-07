<?php

namespace App\Models;

class UserActivation extends BaseModel
{
    protected $table = 'users_activation';

    public function scopeByUser($query, $user_id)
    {
        $query->where('user_id', $user_id);
    }

    public function scopeByToken($query, $token)
    {
        $query->where('token', $token);
    }

}
