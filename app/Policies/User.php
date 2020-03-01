<?php

namespace App\Policies;

use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class User extends BasePolicy
{
    use HandlesAuthorization;

}
