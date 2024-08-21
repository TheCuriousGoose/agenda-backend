<?php

namespace App\Policies;

use App\Models\User;

class EventPolicy
{
    public function create(User $user)
    {
        return $user->role == 'office' || $user->role == 'management';
    }

    public function update(User $user)
    {
        return $user->role == 'office' || $user->role == 'management';
    }

    public function delete(User $user)
    {
        return $user->role == 'management';
    }
}
