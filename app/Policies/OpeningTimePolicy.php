<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OpeningTimePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User     $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, string $openingTimeId)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User     $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, string $openingTimeId)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User     $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, string $openingTimeId)
    {
        return true;
    }

    public function assignTo(User $user, string $openingTimeId, string $referenceType, string $referenceId)
    {
        return true;
    }
}
