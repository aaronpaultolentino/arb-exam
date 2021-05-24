<?php

namespace ARB\RolesAndPermission;

use App\User;

class RolesAndPermissionManager
{
    /**
     * @param User $user
     * @param $action
     */
    public static function hasAccess(User $user, $action)
    {
        if ($user->role->permissions->where('action', $action)->count() === 1) {
            return true;
        }
        return false;
    }
}
