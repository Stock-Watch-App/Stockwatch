<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Stock extends BasePolicy
{
    use HandlesAuthorization;


    protected $model = 'stock';

}
