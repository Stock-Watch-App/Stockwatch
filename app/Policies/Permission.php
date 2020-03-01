<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Permission
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->can('edit permissions')) {
            return true;
        }
    }
}
