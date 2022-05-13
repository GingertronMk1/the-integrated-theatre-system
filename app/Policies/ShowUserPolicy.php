<?php

namespace App\Policies;

use App\Models\Show\ShowUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShowUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ShowUser $showUser)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ShowUser $showUser)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ShowUser $showUser)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ShowUser $showUser)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Show\ShowUser  $showUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ShowUser $showUser)
    {
        return true;
    }
}
