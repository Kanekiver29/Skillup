<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Module;

class ModulePolicy
{
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return $user->hasStaffAccess();
    }

    public function view(User $user, Module $module)
    {
        return $user->hasStaffAccess() || $module->is_published;
    }

    public function create(User $user)
    {
        return $user->hasStaffAccess();
    }

    public function update(User $user, Module $module)
    {
        return $user->hasStaffAccess();
    }

    public function delete(User $user, Module $module)
    {
        return $user->hasStaffAccess();
    }
}
