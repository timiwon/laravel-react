<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, string $areaId)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User     $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, string $areaId, string $tableId)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, string $areaId)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User     $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, string $areaId, string $tableId)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User     $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, string $areaId, string $tableId)
    {
        return true;
    }

    public function assignToArea(User $user, string $areaId, string $tableId, string $newAreaId)
    {
        return true;
    }

    public function combineTables(User $user, string $areaId, string $tableId)
    {
        return true;
    }
}
