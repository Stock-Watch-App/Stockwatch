<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Week extends BasePolicy
{
    use HandlesAuthorization;

    protected $model = 'week';

}
