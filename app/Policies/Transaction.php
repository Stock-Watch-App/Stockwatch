<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Transaction extends BasePolicy
{
    use HandlesAuthorization;


    protected $model = 'transaction';

}
