<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Permission
{
    use HandlesAuthorization;

    protected $model = 'permission';


    public function viewAny(User $user)
    {
        if ($user->can('edit permissions')) {
            return true;
        }
    }
}
