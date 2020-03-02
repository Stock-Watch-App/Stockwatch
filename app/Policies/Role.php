<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Role
{
    use HandlesAuthorization;

    protected $model = 'role';


    public function viewAny(User $user)
    {
        if ($user->can('edit permissions')) {
            return true;
        }
    }
}
