<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Rating extends BasePolicy
{
    use HandlesAuthorization;

}
