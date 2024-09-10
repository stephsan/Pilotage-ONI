<?php

namespace App\Policies;

use App\Models\User;

class TachePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function create(User $user)
    {
        return $this->getPermission($user,12);
    }
    public function view(User $user)
    {
        return $this->getPermission($user,13);
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
