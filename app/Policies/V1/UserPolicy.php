<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Permissions\V1\Abilities;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function store(User $user)
    {
        return $user->tokenCan(Abilities::CreateUser);
    }

    public function delete(User $user)
    {
        return $user->tokenCan(Abilities::DeleteUser);
    }

    public function replace(User $user)
    {
        return $user->tokenCan(Abilities::ReplaceUser);
    }

    public function update(User $user)
    {
        return $user->tokenCan(Abilities::UpdateUser);
    }
}
