<?php

namespace App\Policies;

use App\Models\User;

class RegistrePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function acceder_a_la_synthese(User $user)
    {
        return $this->getPermission($user,15);
    }
    public function enregistrer_dans_le_registre(User $user)
    {
        return $this->getPermission($user,18);
    }
    public function modifier_le_registre(User $user)
    {
        return $this->getPermission($user,19);
    }
    public function acceder_au_registre(User $user)
    {
        return $this->getPermission($user,20);
    }
    public function getPermission($user,$permission_id){
        foreach($user->roles as $user_role){
            foreach($user_role->permissions as $permission_role){
                if($permission_role->id == $permission_id){
                    return true;
                }
        }
    }
    return false;
}
}
