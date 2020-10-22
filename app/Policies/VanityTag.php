<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VanityTag extends BasePolicy
{
    use HandlesAuthorization;

    protected $model = 'vanity-tag';

}
