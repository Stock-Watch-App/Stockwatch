<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Session extends BasePolicy
{
    use HandlesAuthorization;

    protected $model = 'session';

}
