<?php

namespace App\Policies;

use App\Models\User;

class FormulairePolicy
{
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $this->getPermission($user, 8);
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    // emmetre les formulaire en production
    public function create(User $user)
    {
        return $this->getPermission($user, 6);
    }

    public function receptionne(User $user)
    {
        return $this->getPermission($user, 7);
    }

    public function update_reception(User $user)
    {
        return $this->getPermission($user, 11);
    }

    public function recap_formulaire(User $user)
    {
        return $this->getPermission($user, 22);
    }

    public function lister_reception_formulaire(User $user)
    {
        return $this->getPermission($user, 26);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $this->getPermission($user, 5);
    }

    public function valider(User $user)
    {
        return $this->getPermission($user, 3);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $this->getPermission($user, 3);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        return $this->getPermission($user, 3);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {

    }

    public function getPermission($user, $permission_id)
    {
        foreach ($user->roles as $user_role) {
            foreach ($user_role->permissions as $permission_role) {
                if ($permission_role->id == $permission_id) {
                    return true;
                }
            }
        }

        return false;
    }
}
