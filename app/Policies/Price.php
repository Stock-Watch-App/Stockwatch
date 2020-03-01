<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Price extends BasePolicy
{
    use HandlesAuthorization;

}
