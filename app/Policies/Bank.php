<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Bank extends BasePolicy
{
    use HandlesAuthorization;

}
