<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage users (list/create/edit/delete).
     */
    public function manageUsers(User $user)
    {
        // Admins can do everything. Staff can manage users but with limited scope.
        return in_array($user->role, ['admin', 'staff']);
    }

    public function viewAny(User $user)
    {
        return $this->manageUsers($user);
    }

    public function view(User $user, User $model)
    {
        return $this->manageUsers($user) || $user->id === $model->id;
    }

    public function create(User $user)
    {
        return $this->manageUsers($user);
    }

    public function update(User $user, User $model)
    {
        return $this->manageUsers($user) || $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        return $this->manageUsers($user) && $user->id !== $model->id;
    }
}
