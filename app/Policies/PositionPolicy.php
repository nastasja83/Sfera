<?php

namespace App\Policies;

use App\User;
use App\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create positions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the position.
     *
     * @param  \App\User  $user
     * @param  \App\Position  $position
     * @return mixed
     */
    public function update(User $user, Position $position)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the position.
     *
     * @param  \App\User  $user
     * @param  \App\Position  $position
     * @return mixed
     */
    public function delete(User $user, Position $position)
    {
        return $user->isAdmin();
    }
}
