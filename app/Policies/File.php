<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class File extends BasePolicy
{
    use HandlesAuthorization;

    protected $model = 'file';


}
