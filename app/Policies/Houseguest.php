<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Houseguest extends BasePolicy
{
    use HandlesAuthorization;

}
